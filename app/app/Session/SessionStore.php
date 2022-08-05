<?php

declare(strict_types=1);

namespace App\Session;

interface SessionStore
{
    public function get(string $key, $default = null): mixed;
    public function set(mixed $key, $value = null): void;
    public function exists(string $key): bool;
    public function clear(...$keys): void;
}