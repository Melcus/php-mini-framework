<?php

declare(strict_types=1);

namespace App\Views;

use Laminas\Diactoros\Response;
use Twig\Environment;

class View
{
    public function __construct(protected Environment $twig)
    {
    }

    public function render(Response $response, string $view, $data = []): Response
    {
        $response->getBody()->write(
            $this->twig->render($view, $data)
        );

        return $response;
    }
}
