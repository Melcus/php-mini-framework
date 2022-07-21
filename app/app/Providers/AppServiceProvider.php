<?php

declare(strict_types=1);

namespace App\Providers;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;

class AppServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            Router::class,
            'request',
            'response',
            'emitter',
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Router::class, function () use ($container) {
            $strategy = new ApplicationStrategy();
            $strategy->setContainer($container);
            return (new Router)->setStrategy($strategy);
        });

        $container->addShared('request', function () {
            return ServerRequestFactory::fromGlobals(
                server: $_SERVER,
                query: $_GET,
                body: $_POST,
                cookies: $_COOKIE,
                files: $_FILES,
            );
        });

        $container->addShared('response', Response::class);

        $container->addShared('emitter', function () {
            return new SapiEmitter;
        });
    }
}
