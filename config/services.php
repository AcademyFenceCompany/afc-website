<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'ups' => [
    'client_id' => env('UPS_CLIENT_ID'),
    'client_secret' => env('UPS_CLIENT_SECRET'),
    'production' => env('UPS_PRODUCTION', true),
],
'rl' => [
    'api_url' => env('RL_API_URL'),
    'api_key' => env('RL_API_KEY'),
],
'tforce' => [
    'client_id' => env('TFORCE_CLIENT_ID'),
    'client_secret' => env('TFORCE_CLIENT_SECRET'),
    'token_endpoint' => env('TFORCE_TOKEN_ENDPOINT'),
    'scope' => env('TFORCE_SCOPE'),
    'access_token' => env('TFORCE_ACCESS_TOKEN'),

],
'authorize_net' => [
    'api_login_id' => env('AUTHORIZE_NET_API_LOGIN_ID'),
    'transaction_key' => env('AUTHORIZE_NET_TRANSACTION_KEY'),
    'environment' => env('AUTHORIZE_NET_ENVIRONMENT', 'sandbox'),
],

];
