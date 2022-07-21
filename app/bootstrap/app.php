<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Dotenv\Exception\InvalidPathException;
use League\Container\Container;
use League\Route\Router;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

/* Load environment variables */
try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/../")->load();
} catch (InvalidPathException $exception) {
    die($exception->getMessage());
}

/* Container setup */
$container = (new Container)->addServiceProvider(new AppServiceProvider());

/* Router setup */
$router = $container->get(Router::class);

require_once __DIR__ . '/../routes/web.php';

$response = $router->dispatch($container->get('request'));

$container->get('emitter')->emit($response);
