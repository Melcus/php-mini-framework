<?php

declare(strict_types=1);

namespace App\Cookie;

class CookieJar
{
    protected string $path = '/';

    protected string $domain = '';

    protected bool $secure = false;

    protected bool $httpOnly = true;

    public function set(string $key, string $value, int $minutes = 60): void
    {
        $expiry = time() + ($minutes * 60);

        setcookie($key, $value, $expiry, $this->path, $this->domain, $this->secure, $this->httpOnly);
    }

    public function get(string $key, $default = null): mixed
    {
        return $_COOKIE[$key] ?? $default;
    }

    public function exists(string $key): bool
    {
        return isset($_COOKIE[$key]) && !empty($_COOKIE[$key]);
    }

    public function clear(string $key): void
    {
        $this->set($key, '', time() - 3600); // Set the cookie to expire in the past
    }

    public function forever(string $key, mixed $value): void
    {
        $this->set($key, $value, 2147483647);  // maximum value compatible with 32 bits systems
    }
}
