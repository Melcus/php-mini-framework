<?php

declare(strict_types=1);

if (!function_exists('base_path')) {
    function base_path($path = ''): string
    {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
