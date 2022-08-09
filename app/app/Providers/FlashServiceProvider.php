<?php

declare(strict_types=1);

namespace App\Providers;

use App\Session\Flash;
use App\Session\SessionStore;
use League\Container\ServiceProvider\AbstractServiceProvider;

class FlashServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [Flash::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Flash::class, function () use ($container){
            return new Flash($container->get(SessionStore::class));
        });
    }
}
