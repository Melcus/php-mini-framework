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

    public function share(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->twig->addGlobal($key, $value);
        }
    }
}
