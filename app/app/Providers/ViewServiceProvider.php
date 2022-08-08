<?php

declare(strict_types=1);

namespace App\Providers;

use App\Config\Config;
use App\Views\Extensions\RouteExtension;
use App\Views\View;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class ViewServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [View::class];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $config = $container->get(Config::class);

        $router = $container->get(Router::class);

        $container->addShared(View::class, function () use ($config, $router) {
            $loader = new FilesystemLoader(base_path('views'));

            $twig = new Environment($loader, [
                'cache' => $config->get('cache.views.enabled') ? $config->get('cache.views.path') : false,
                'debug' => $config->get('app.debug'),
            ]);

            if($config->get('app.debug')) {
                $twig->addExtension(new DebugExtension);
            }

            $twig->addExtension(new RouteExtension($router));

            return new View($twig);
        });
    }
}
