<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Config\Config;
use App\Views\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ViewShareMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected View $view,
        protected Config $config
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->view->share([
            'config' => $this->config,
        ]);

        return $handler->handle($request);
    }
}