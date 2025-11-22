<?php

namespace App\Services;

use GuzzleHttp\Client;

class MpesaService
{
    protected $shortcode;
    protected $lipaNaMpesaPasskey;
    protected $consumerKey;
    protected $consumerSecret;
    protected $env;
    protected $callbackUrl;

    public function __construct()
    {
        $this->shortcode = env('MPESA_SHORTCODE');
        $this->lipaNaMpesaPasskey = env('MPESA_PASSKEY');
        $this->consumerKey = env('MPESA_CONSUMER_KEY');
        $this->consumerSecret = env('MPESA_CONSUMER_SECRET');
        $this->env = env('MPESA_ENV', 'sandbox'); // sandbox or live
        $this->callbackUrl = env('MPESA_CALLBACK_URL');
    }

    protected function getAccessToken()
    {
        $url = $this->env === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $client = new Client();
        $response = $client->get($url, [
            'auth' => [$this->consumerKey, $this->consumerSecret]
        ]);

        $body = json_decode($response->getBody()->getContents());
        return $body->access_token ?? null;
    }

    public function stkPush($phone, $amount, $accountReference, $transactionDesc)
    {
        $accessToken = $this->getAccessToken();

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->lipaNaMpesaPasskey . $timestamp);

        $url = $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $client = new Client();
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ],
            'json' => [
                "BusinessShortCode" => $this->shortcode,
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => $this->shortcode,
                "PhoneNumber" => $phone,
                "CallBackURL" => $this->callbackUrl,
                "AccountReference" => $accountReference,
                "TransactionDesc" => $transactionDesc
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
