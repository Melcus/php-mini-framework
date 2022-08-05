<?php

declare(strict_types=1);

namespace App\Providers;

use App\Session\FileSession;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class SessionServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [SessionStore::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(SessionStore::class, function () {
            return new FileSession();
        });
    }
}
