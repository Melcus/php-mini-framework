<?php

declare(strict_types=1);

namespace App\Security;

use App\Session\SessionStore;

class Csrf
{
    public const SESSION_KEY = '_token';

    protected bool $persistToken = false;

    public function __construct(protected SessionStore $session)
    {
    }

    protected function tokenNeedsToBeGenerated(): bool
    {
        if (!$this->session->exists(self::SESSION_KEY)) {
            return true;
        }

        if ($this->persistToken) {
            return false;
        }

        return $this->session->exists(self::SESSION_KEY);
    }

    public function tokenIsValid(?string $token): bool
    {
        return $token === $this->session->get(self::SESSION_KEY);
    }

    public function token(): string
    {
        if (!$this->tokenNeedsToBeGenerated()) {
            return $this->session->get(self::SESSION_KEY);
        }

        $this->session->set(
            self::SESSION_KEY,
            $token = bin2hex(random_bytes(32))
        );

        return $token;
    }
}
