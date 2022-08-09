<?php

use App\Middleware\Authenticate;
use App\Middleware\ClearValidationErrors;
use App\Middleware\CsrfGuard;
use App\Middleware\ShareValidationErrors;
use App\Middleware\ViewShareMiddleware;
use App\Providers\{AppServiceProvider,
    AuthServiceProvider,
    CsrfServiceProvider,
    DatabaseServiceProvider,
    FlashServiceProvider,
    HashServiceProvider,
    SessionServiceProvider,
    ViewServiceProvider};

return [
    'name' => env('APP_NAME', 'Funky'),

    'debug' => env('APP_DEBUG', false),

    'providers' => [
        AppServiceProvider::class,
        ViewServiceProvider::class,
        DatabaseServiceProvider::class,
        SessionServiceProvider::class,
        HashServiceProvider::class,
        AuthServiceProvider::class,
        FlashServiceProvider::class,
        CsrfServiceProvider::class
    ],

    'middleware' => [
        ShareValidationErrors::class,
        ClearValidationErrors::class,
        ViewShareMiddleware::class,
        Authenticate::class,
        CsrfGuard::class
    ]
];
