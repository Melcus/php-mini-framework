<?php

declare(strict_types=1);

namespace App\Session;

class Flash
{
    protected array $messages = [];

    public function __construct(protected SessionStore $session)
    {
        $this->loadFlashMessagesIntoCache();

        $this->clear();
    }

    public function has(string $key): bool
    {
        return isset($this->messages[$key]);
    }

    public function hasValues(): bool
    {
        return !empty($this->messages);
    }

    public function get(string $key): ?string
    {
        return $this->messages[$key] ?? null;
    }

    public function now(string $key, string $value): void
    {
        $this->session->set('flash', array_merge(
            $this->session->get('flash') ?? [], [$key => $value]
        ));
    }

    protected function loadFlashMessagesIntoCache(): void
    {
        $this->messages = $this->session->get('flash') ?? [];
    }

    protected function clear(): void
    {
        $this->session->clear('flash');
    }
}
