<?php

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

global $router;

$router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
    $response = new Response;

    $response->getBody()->write('<h3>Hello, World!</h3>');

    return $response;
});
