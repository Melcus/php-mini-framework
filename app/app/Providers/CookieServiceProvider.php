<?php

declare(strict_types=1);

namespace App\Providers;

use App\Cookie\CookieJar;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CookieServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [CookieJar::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()->addShared(CookieJar::class, function () {
            return new CookieJar();
        });
    }
}
