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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'quickbook' => [
        'client_id' => env('QB_CLIENT_ID'),
        'client_secret' => env('QB_CLIENT_SECRET'),
        'redirect' => env('QB_REDIRECT_URI'),
        'auth_base_url' => env('QB_AUTH_BASE_URL'),
        'token_base_url' => env('QB_TOKEN_BASE_URL'),
        'quick_book_base_url' => env('QB_BASE_URL'),
        'quick_book_oauth_scope' => env('QB_OAUTH_SCOPE'),
    ],

];
