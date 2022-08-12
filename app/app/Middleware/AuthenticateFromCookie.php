<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Auth\Auth;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticateFromCookie implements MiddlewareInterface
{
    public function __construct(protected Auth $auth)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if($this->auth->check()) {
            return $handler->handle($request);
        }

        if($this->auth->hasRecaller()) {
            try {
              $this->auth->setUserFromCookie();
            } catch (Exception $exception) {
                $this->auth->logout();
            }
        }

        return $handler->handle($request);
    }
}
