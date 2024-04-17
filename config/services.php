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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'yapo' => [
        'client_id' => env("YAPO_CLIENT_ID"),
        'client_secret' => env("YAPO_SECRET_CLIENT"),
        'redirect' => env("YAPO_AUTH_URL").'?client_id='.env("YAPO_CLIENT_ID").'&redirect_url='.env("YAPO_REDIRECT_URL"),
    ],

    /*YAPO_AUTH_URL=https://w.yapo.cl/yapo-api-auth/authorization
    YAPO_API_URL=https://integration.yapo.cl/yapo-api
    YAPO_CLIENT_ID=benjaminperez
    YAPO_SECRET_CLIENT=b67e2b17e9d754b7615c2837adcd4ff0
    YAPO_REDIRECT_URL=https://www.google.com
    YAPO_USER=admin@benjaminperez.cl
    YAPO_PASSWORD=Yapito2024*/
];
