<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Session\SessionStore;
use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShareValidationErrors implements MiddlewareInterface
{
    public function __construct(
        protected View $view,
        protected SessionStore $session
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->view->share([
            'errors' => $this->session->get('errors', []),
            'old' => $this->session->get('old', [])
        ]);

        return $handler->handle($request);
    }
}