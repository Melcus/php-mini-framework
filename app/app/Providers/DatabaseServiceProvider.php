<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config\Config;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class DatabaseServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [EntityManager::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $config = $container->get(Config::class);

        $container->addShared(EntityManager::class, function () use ($config) {
            return EntityManager::create(
                $config->get('database.' . env('DB_CONNECTION')),
                ORMSetup::createAnnotationMetadataConfiguration(
                    [base_path('app/Entities')],
                    $config->get('app.debug'),
                    null,
                    new FilesystemAdapter()
                )
            );
        });
    }
}
