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

    'vonage'=>[
        'sms_from'=>'15556666666',
        'key'=>env('VONAGE_KEY'),  //neeeww
        'secret'=>env('VONAGE_SECRET')
    ],

    'nepras'=>[   //neeeewwww
        'user'=>env('NEPRAS_USER'),
        'pass'=>env('NEPRAS_PASS'),
        'sender'=>env('NEPRAS_SENDER')
    ],

    'thawani'=>[
        'secret_key'=>env('THAWANI_SECRET_kEY'),
        'publishable_key'=>env('THAWANI_PUBLISHABLE_kEY'),
        'mode'=>'test',
    ]

];
