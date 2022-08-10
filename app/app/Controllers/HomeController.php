<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __construct(protected View $view)
    {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return $this->view->render(new Response, 'home.twig');
    }
}
