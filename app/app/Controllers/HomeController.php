<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;

class HomeController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;

        $response->getBody()->write('<h3>Hello, World!</h3>');

        return $response;
    }
}
