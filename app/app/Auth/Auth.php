<?php

declare(strict_types=1);

namespace App\Auth;

use App\Auth\Hashing\Hasher;
use App\Entities\User;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use Exception;

class Auth
{
    protected const AUTH_SESSION_KEY = 'auth';

    private ?User $user = null;

    public function __construct(
        protected EntityManager $db,
        protected Hasher $hasher,
        protected SessionStore $session
    ) {
    }

    public function user(): ?User
    {
        return $this->user;
    }

    public function check(): bool
    {
        return $this->hasUserInSession();
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->getUserBy('email', $email);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->hasher->needsRehash($user->password)) {
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);

        return true;
    }

    public function logout(): void
    {
        // todo: implement
    }

    public function hasUserInSession(): bool
    {
        return $this->session->exists(self::AUTH_SESSION_KEY);
    }

    public function setUserFromSession(): void
    {
        $user = $this->getUserBy('id', $this->session->get(self::AUTH_SESSION_KEY));

        if (!$user) {
            throw new Exception();
        }

        $this->user = $user;
    }

    protected function rehashPassword(User $user, string $password): void
    {
        $user->update(['password' => $this->hasher->create($password)]);

        $this->db->flush();
    }

    protected function getUserBy(string $field, mixed $value): ?User
    {
        return $this->db->getRepository(User::class)->findOneBy([
            $field => $value
        ]);
    }

    protected function hasValidCredentials(User $user, string $password): bool
    {
        return $this->hasher->check($password, $user->password);
    }

    protected function setUserSession(User $user): void
    {
        $this->session->set(self::AUTH_SESSION_KEY, $user->id);
    }
}
