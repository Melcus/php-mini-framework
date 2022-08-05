<?php

declare(strict_types=1);

namespace App\Session;

class FileSession implements SessionStore
{

    public function get(string $key, $default = null): mixed
    {
        if ($this->exists($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(mixed $key, $value = null): void
    {
        if (is_array($key)) {
            foreach ($key as $sessionKey => $sessionValue) {
                $_SESSION[$sessionKey] = $sessionValue;
            }
            return;
        }

        $_SESSION[$key] = $value;
    }

    public function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function clear(...$keys): void
    {
        foreach ($keys as $sessionKey) {
            unset($_SESSION[$sessionKey]);
        }
    }
}