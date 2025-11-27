<?php

return [

    'consumer_key' => 'YOUR_CONSUMER_KEY_HERE',
    'consumer_secret' => 'YOUR_CONSUMER_SECRET_HERE',

    'shortcode' => '174379', // Test paybill
    'passkey' => 'YOUR_PASSKEY_HERE',

    // Daraja URLs
    'oauth_url' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials',
    'stk_url' => 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',

    'callback_url' => env('APP_URL') . '/api/mpesa/callback',

];

// return [
//     'consumer_key' => env('MPESA_CONSUMER_KEY'),
//     'consumer_secret' => env('MPESA_CONSUMER_SECRET'),
//     'shortcode' => env('MPESA_SHORTCODE'),
//     'passkey' => env('MPESA_PASSKEY'),
//     'callback_url' => env('MPESA_CALLBACK_URL'),
//     'env' => env('MPESA_ENV', 'sandbox'), // 'sandbox' or 'live'
// ];
