<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\ServerRequestInterface;

class ValidationException extends Exception
{
    public function __construct(
        protected ServerRequestInterface $request,
        protected array $errors
    ) {
        parent::__construct();
    }

    public function getPath(): string
    {
        return $this->request->getUri()->getPath();
    }

    public function getOldInput(): array
    {
        return $this->request->getParsedBody();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
