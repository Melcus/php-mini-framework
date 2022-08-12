<?php

use App\Middleware\AuthenticateFromCookie;
use App\Middleware\AuthenticateFromSession;
use App\Middleware\ClearValidationErrors;
use App\Middleware\CsrfGuard;
use App\Middleware\ShareValidationErrors;
use App\Middleware\ViewShareMiddleware;
use App\Providers\{AppServiceProvider,
    AuthServiceProvider,
    CookieServiceProvider,
    CsrfServiceProvider,
    DatabaseServiceProvider,
    FlashServiceProvider,
    HashServiceProvider,
    SessionServiceProvider,
    ValidationServiceProvider,
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
        CsrfServiceProvider::class,
        ValidationServiceProvider::class,
        CookieServiceProvider::class
    ],

    'middleware' => [
        ShareValidationErrors::class,
        ClearValidationErrors::class,
        ViewShareMiddleware::class,
        AuthenticateFromCookie::class,
        AuthenticateFromSession::class,
        CsrfGuard::class
    ]
];
