<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Session\SessionStore;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClearValidationErrors implements MiddlewareInterface
{
    public function __construct(
        protected SessionStore $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $next = $handler->handle($request);

        $this->session->clear('errors', 'old');

        return $next;
    }
}