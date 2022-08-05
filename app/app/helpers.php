<?php

declare(strict_types=1);

use Laminas\Diactoros\Response\RedirectResponse;

if (!function_exists('base_path')) {
    function base_path($path = ''): string
    {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('env')) {
    function env($key, $default = null): mixed
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return match (strtolower($value)) {
            'true' => true,
            'false' => false,
            default => $value,
        };
    }
}

if (!function_exists('redirect')) {
    function redirect($path): RedirectResponse
    {
       return new RedirectResponse($path);
    }
}
