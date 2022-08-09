<?php

declare(strict_types=1);

namespace App\Providers;

use App\Security\Csrf;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CsrfServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [Csrf::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Csrf::class, function () use ($container) {
            return new Csrf(
                $container->get(SessionStore::class)
            );
        });
    }
}
