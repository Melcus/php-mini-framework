<?php

declare(strict_types=1);

namespace App\Views\Extensions;

use League\Route\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{
    public function __construct(protected Router $router) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('route', [$this, 'route']),
            new TwigFunction('isRoute', [$this, 'isRoute']),
        ];
    }

    public function route(string $name): string
    {
        return $this->router->getNamedRoute($name)->getPath();
    }

    public function isRoute(string $name): bool
    {
        return $_SERVER['REQUEST_URI'] === $this->route($name);
    }
}