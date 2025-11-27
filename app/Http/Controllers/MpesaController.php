<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    /**
     * Show the checkout page
     */
    public function checkout(Campaign $campaign)
    {
        return view('donations.checkout', compact('campaign'));
    }

    /**
     * STK Push donation
     */
    public function donate(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'phone' => 'required|string',
        ]);

        try {
            $campaign = Campaign::findOrFail($request->campaign_id);

            // Format phone
            $phone = ltrim($request->phone, '+');
            if (substr($phone, 0, 1) === '0') {
                $phone = '254' . substr($phone, 1);
            }

            // STK values
            $timestamp = Carbon::now()->format('YmdHis');
            $shortcode = env('MPESA_SHORTCODE');
            $passkey = env('MPESA_PASSKEY');
            
            if (!$shortcode || !$passkey) {
                throw new \Exception('M-Pesa configuration missing (MPESA_SHORTCODE or MPESA_PASSKEY)');
            }
            
            $password = base64_encode($shortcode . $passkey . $timestamp);

            // Access token
            $tokenResponse = Http::withBasicAuth(
                env('MPESA_CONSUMER_KEY'),
                env('MPESA_CONSUMER_SECRET')
            )->get(
                'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            );

            if (!$tokenResponse->successful()) {
                Log::error('Token generation failed:', $tokenResponse->json());
                throw new \Exception('Failed to generate M-Pesa access token');
            }

            $token = $tokenResponse['access_token'];

            // STK request
            $response = Http::withToken($token)->post(
                'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                    "BusinessShortCode" => $shortcode,
                    "Password" => $password,
                    "Timestamp" => $timestamp,
                    "TransactionType" => "CustomerPayBillOnline",
                    "Amount" => (int)$request->amount,
                    "PartyA" => $phone,
                    "PartyB" => $shortcode,
                    "PhoneNumber" => $phone,
                    "CallBackURL" => env('MPESA_CALLBACK_URL'),
                    "AccountReference" => "Donation",
                    "TransactionDesc" => "Donation to {$campaign->title}",
                ]
            );

            Log::info('STK Response:', $response->json());

            if (!$response->successful()) {
                Log::error('STK Push failed:', $response->json());
                throw new \Exception('M-Pesa STK push failed');
            }

            $responseData = $response->json();

            // Save pending payment (campaign may be null if general donation)
            Payment::create([
                'campaign_id'   => $campaign->id ?? null,
                'user_id'       => Auth::id(),
                'amount'        => $request->amount,
                'phone'         => $phone,
                'checkout_id'   => $responseData['MerchantRequestID'] ?? null,
                'status'        => 'pending',
            ]);

            return response()->json(['success' => true, 'message' => 'Check your phone to complete the payment']);

        } catch (\Exception $e) {
            Log::error('Donation error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }

    /**
     * Callback from Safaricom
     */
    public function callback(Request $request)
    {
        Log::info('MPESA CALLBACK:', $request->all());

        try {
            $body = $request->input('Body.stkCallback');

            if (!$body) {
                Log::warning('Invalid callback: no stkCallback body');
                return response()->json(['success' => false], 400);
            }

            $checkout_id = $body['MerchantRequestID'] ?? null;
            $result_code = $body['ResultCode'] ?? null;

            if (!$checkout_id) {
                Log::warning('Invalid callback: no MerchantRequestID');
                return response()->json(['success' => false], 400);
            }

            $payment = Payment::where('checkout_id', $checkout_id)->first();

            if ($payment) {
                if ($result_code == 0) {
                    // SUCCESS
                    $metadata = $body['CallbackMetadata']['Item'] ?? [];
                    $transactionCode = null;
                    
                    // Extract receipt number from metadata
                    foreach ($metadata as $item) {
                        if (($item['Name'] ?? null) === 'MpesaReceiptNumber') {
                            $transactionCode = $item['Value'] ?? null;
                            break;
                        }
                    }

                    $payment->update([
                        'status' => 'paid',
                        'transaction_code' => $transactionCode
                    ]);

                    Log::info('Payment marked as paid:', ['payment_id' => $payment->id]);
                } else {
                    // FAILED
                    $payment->update([
                        'status' => 'failed'
                    ]);

                    Log::info('Payment marked as failed:', ['payment_id' => $payment->id, 'result_code' => $result_code]);
                }
            } else {
                Log::warning('Payment not found for checkout_id:', ['checkout_id' => $checkout_id]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Callback processing error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function success()
    {
        return view('donations.success');
    }
}
