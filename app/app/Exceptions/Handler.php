<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Session\SessionStore;
use Exception;
use Laminas\Diactoros\Response\RedirectResponse;
use ReflectionClass;

class Handler
{
    public function __construct(
        protected Exception $exception,
        protected SessionStore $session
    ) {
    }

    /** @throws Exception */
    public function respond(): RedirectResponse
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

    /** @throws Exception */
    protected function unhandledException(Exception $exception)
    {
        throw $exception;
    }
}