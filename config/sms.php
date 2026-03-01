<?php

use App\Services\Sms\EskizProviderService;
use App\Services\Sms\FakeProviderService;
use App\Services\Sms\PlaymobileProviderService;

return [
    'providers' => [
        'fake' => [
            'class' => FakeProviderService::class,
        ],
        'eskiz' => [
            'class' => EskizProviderService::class,
            'token' => env('ESKIZ_TOKEN'),
            'base_url' => env('ESKIZ_BASE_URL', 'https://eskiz.uz'),
        ],
        'playmobile' => [
            'class' => PlaymobileProviderService::class,
            'api_key' => env('PLAYMOBILE_API_KEY'),
            'base_url' => env('PLAYMOBILE_BASE_URL', 'https://playmobile.uz'),
        ],
    ],
];
