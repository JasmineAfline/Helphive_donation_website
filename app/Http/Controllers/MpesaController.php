<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    /**
     * Show the checkout page for a specific campaign
     */
    public function checkout(Campaign $campaign)
    {
        return view('donations.checkout', compact('campaign'));
    }

    /**
     * Handle M-Pesa STK Push donation
     */
    public function donate(Request $request)
    {
        // Validate request
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:1',
            'phone' => 'required|string',
        ]);

        $campaign = Campaign::findOrFail($request->campaign_id);

        // ✅ FORMAT PHONE NUMBER TO 2547XXXXXXXX
        $phone = $request->phone;
        $phone = ltrim($phone, '+');
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }

        // Prepare STK Push
        $timestamp = Carbon::now()->format('YmdHis');
        $shortcode = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $password = base64_encode($shortcode . $passkey . $timestamp);
        $callbackUrl = env('MPESA_CALLBACK_URL');

        $url = env('MPESA_ENV') === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $payload = [
            "BusinessShortCode" => $shortcode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $request->amount,
            "PartyA" => $phone,
            "PartyB" => $shortcode,
            "PhoneNumber" => $phone,
            "CallBackURL" => $callbackUrl,
            "AccountReference" => "Donation",
            "TransactionDesc" => "Donation to " . $campaign->title
        ];

        try {
            // ✅ GET ACCESS TOKEN FIRST
            $tokenResponse = Http::withBasicAuth(
                env('MPESA_CONSUMER_KEY'),
                env('MPESA_CONSUMER_SECRET')
            )->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

            if (!$tokenResponse->successful()) {
                Log::error('MPESA Token Error:', ['response' => $tokenResponse->body()]);
                return back()->withErrors(['payment_error' => 'Failed to generate M-Pesa access token.']);
            }

            $accessToken = $tokenResponse->json()['access_token'];

            // ✅ SEND STK PUSH WITH TOKEN
            $response = Http::withToken($accessToken)->post($url, $payload);

            Log::info('MPESA STK Push Payload:', $payload);
            Log::info('MPESA STK Push Response:', ['body' => $response->body()]);

            if ($response->successful()) {

                // Save pending donation
                Donation::create([
                    'user_id' => Auth::id(),
                    'campaign_id' => $campaign->id,
                    'amount' => $request->amount,
                    'payment_method' => 'mpesa',
                    'phone' => $phone,
                    'status' => 'pending',
                ]);

                return redirect()->route('mpesa.success')
                    ->with('success', 'Check your phone to complete the payment.');
            }

            return back()->withErrors([
                'payment_error' => 'Failed to initiate M-Pesa payment: ' . $response->body()
            ]);

        } catch (\Exception $e) {
            Log::error('MPESA STK Push Exception: ', ['message' => $e->getMessage()]);
            return back()->withErrors([
                'payment_error' => 'Something went wrong: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * M-Pesa Callback
     */
    public function callback(Request $request)
    {
        Log::info('MPESA Callback Received:', $request->all());
        return response()->json(['success' => true]);
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('donations.success');
    }
}
