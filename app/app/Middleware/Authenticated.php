<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Auth\Auth;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Authenticated implements MiddlewareInterface
{
    public function __construct(
        protected Auth $auth,
        protected Router $router
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->auth->check()) {
            return new RedirectResponse($this->router->getNamedRoute('login')->getPath());
        }

        return $handler->handle($request);
    }
}
