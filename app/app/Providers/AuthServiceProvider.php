<?php

declare(strict_types=1);

namespace App\Providers;

use App\Auth\Auth;
use App\Auth\Hashing\Hasher;
use App\Auth\Recaller;
use App\Cookie\CookieJar;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [Auth::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Auth::class, function () use ($container) {
            return new Auth(
                db: $container->get(EntityManager::class),
                hasher: $container->get(Hasher::class),
                session: $container->get(SessionStore::class),
                cookieJar: $container->get(CookieJar::class),
                recaller: new Recaller(),
            );
        });
    }
}
