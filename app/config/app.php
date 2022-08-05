<?php

use App\Providers\{AppServiceProvider, DatabaseServiceProvider, SessionServiceProvider, ViewServiceProvider};

return [
    'name' => env('APP_NAME', 'Funky'),

    'debug' => env('APP_DEBUG', false),

    'providers' => [
        AppServiceProvider::class,
        ViewServiceProvider::class,
        DatabaseServiceProvider::class,
        SessionServiceProvider::class,
    ]
];
