<?php

declare(strict_types=1);

use App\Exceptions\Handler;
use App\Providers\ConfigServiceProvider;
use App\Session\SessionStore;
use Dotenv\Exception\InvalidPathException;
use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\Router;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

/* Load environment variables */
try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(base_path())->load();
} catch (InvalidPathException $exception) {
    die($exception->getMessage());
}

/* Container setup, Autowire & Service Providers */
$container = (new Container)
    ->delegate(new ReflectionContainer)
    ->addServiceProvider(new ConfigServiceProvider());

foreach ($container->get('config')->get('app.providers') as $provider) {
    $container->addServiceProvider(new $provider);
}

/* Router setup */
$router = $container->get(Router::class);

require_once base_path('routes/web.php');

try {
    $response = $router->dispatch($container->get('request'));
} catch (Exception $exception) {
    $response = (new Handler(
        $exception,
        $container->get(SessionStore::class)
    ))->respond();
}

$container->get('emitter')->emit($response);
