<?php

declare(strict_types=1);

namespace App\Auth\Hashing;

class BcryptHasher implements Hasher
{
    public function create(string $plain): string
    {
        return password_hash($plain, PASSWORD_BCRYPT, $this->options());
    }

    public function check(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }

    public function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, $this->options());
    }

    protected function options(): array
    {
        return [
            'cost' => 12
        ];
    }
}
