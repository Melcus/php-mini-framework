<?php

return [
    'mysql' => [
        'driver' => env('DB_DRIVER', 'pdo_mysql'),
        'host' => env('DB_HOST', 'localhost'),
        'dbname' => env('DB_DATABASE', 'funky'),
        'user' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'root'),
        'port' => env('DB_PORT', 3306),
    ]
];
