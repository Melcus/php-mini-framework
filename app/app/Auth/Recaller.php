<?php

declare(strict_types=1);

namespace App\Auth;

class Recaller
{
    protected const SEPARATOR = '|';

    public function generate(): array
    {
        return [
            $this->generateIdentifier(),
            $this->generateToken()
        ];
    }

    protected function generateIdentifier(): string
    {
        return bin2hex(random_bytes(32));
    }

    protected function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function generateValueForCookie(string $identifier, string $token): string
    {
        return base64_encode("{$identifier}" . self::SEPARATOR . "{$token}");
    }

    public function getTokenHashForDatabase(string $token): string
    {
        return hash('sha256', $token);
    }

    public function splitCookieValue(string $value): array
    {
        return explode(self::SEPARATOR, base64_decode($value));
    }

    public function validateToken(mixed $plainToken, $hashedToken): bool
    {
        return $this->getTokenHashForDatabase($plainToken) === $hashedToken;
    }
}
