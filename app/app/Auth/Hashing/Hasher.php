<?php

declare(strict_types=1);

namespace App\Auth\Hashing;

interface Hasher
{
    public function create(string $plain): string;

    public function check(string $plain, string $hash): bool;

    public function needsRehash(string $hash): bool;
}
