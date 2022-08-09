<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Session\SessionStore;
use App\Views\View;
use Exception;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;

class Handler
{
    public function __construct(
        protected Exception $exception,
        protected SessionStore $session,
        protected View $view
    ) {
    }

    /** @throws Exception */
    public function respond(): ResponseInterface
    {
        $class = (new ReflectionClass($this->exception))->getShortName();

        if (method_exists($this, $method = "handle{$class}")) {
            return $this->{$method}($this->exception);
        }

        return $this->unhandledException($this->exception);
    }

    public function handleValidationException(ValidationException $exception): RedirectResponse
    {
        $this->session->set([
            'errors' => $exception->getErrors(),
            'old' => $exception->getOldInput()
        ]);

        return redirect($exception->getPath());
    }

    public function handleCsrfTokenException(): ResponseInterface
    {
        return $this->view->render(new Response, 'errors/csrf.twig');
    }

    /** @throws Exception */
    protected function unhandledException(Exception $exception)
    {
        throw $exception;
    }
}
