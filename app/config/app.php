<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;

return [
    'name' => getenv('APP_NAME'),

    'debug' => getenv('APP_DEBUG'),

    'providers' => [
        AppServiceProvider::class,
        ViewServiceProvider::class
    ]
];
