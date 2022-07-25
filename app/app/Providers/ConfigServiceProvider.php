<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config\Config;
use App\Config\Loaders\ArrayLoader;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ConfigServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = ['config'];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $this->getContainer()->addShared('config', function () {
            return (new Config)->load([
                new ArrayLoader([
                    'app' => base_path('config/app.php'),
                    'cache' => base_path('config/cache.php'),
                    'database' => base_path('config/database.php'),
                ])
            ]);
        });
    }
}
