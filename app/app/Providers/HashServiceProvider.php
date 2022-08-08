<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\Hashing\BcryptHasher;
use App\Auth\Hashing\Hasher;
use League\Container\ServiceProvider\AbstractServiceProvider;

class HashServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [Hasher::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()->addShared(Hasher::class, function () {
            return new BcryptHasher();
        });
    }
}