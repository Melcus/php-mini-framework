<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;

return [
    'name' => env('APP_NAME', 'Funky'),

    'debug' => env('APP_DEBUG', false),

    'providers' => [
        AppServiceProvider::class,
        ViewServiceProvider::class
    ]
];
