<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;
use Dotenv\Exception\InvalidPathException;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;

require_once __DIR__ . '/../vendor/autoload.php';

//session_start();

/* Load environment variables */
try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(base_path())->load();
} catch (InvalidPathException $exception) {
    die($exception->getMessage());
}

/* Container setup, Autowire & Service Providers */
$container = (new Container)
    ->delegate(new ReflectionContainer)
    ->addServiceProvider(new AppServiceProvider())
    ->addServiceProvider(new ViewServiceProvider());

/* Router setup */
$router = $container->get(Router::class);

require_once base_path('routes/web.php');

$response = $router->dispatch($container->get('request'));

$container->get('emitter')->emit($response);
