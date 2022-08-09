<?php

declare(strict_types=1);

use App\{Auth\Auth,
    Config\Config,
    Exceptions\Handler,
    Providers\ConfigServiceProvider,
    Session\SessionStore,
    Views\View};
use Dotenv\Exception\InvalidPathException;
use League\{Container\Container, Container\ReflectionContainer, Route\Router};

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

foreach ($container->get(Config::class)->get('app.providers') as $provider) {
    $container->addServiceProvider(new $provider);
}

/* Router & Middleware setup */
$router = $container->get(Router::class);

foreach ($container->get(Config::class)->get('app.middleware') as $middleware) {
    $router->middleware($container->get($middleware));
}

require_once base_path('routes/web.php');

/* Handle response */
try {
    $response = $router->dispatch($container->get('request'));
} catch (Exception $exception) {
    $response = (new Handler(
        $exception,
        $container->get(SessionStore::class),
        $container->get(View::class),
    ))->respond();
}

ray($_SESSION, $container->get(Auth::class));

$container->get('emitter')->emit($response);
