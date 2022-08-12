<?php

declare(strict_types=1);

namespace App\Auth;

use App\Auth\Hashing\Hasher;
use App\Cookie\CookieJar;
use App\Entities\User;
use App\Session\SessionStore;
use Doctrine\ORM\EntityManager;
use Exception;

class Auth
{
    protected const AUTH_SESSION_KEY = 'auth';
    protected const REMEMBER_COOKIE_KEY = 'remember';

    private ?User $user = null;

    public function __construct(
        protected EntityManager $db,
        protected Hasher $hasher,
        protected SessionStore $session,
        protected CookieJar $cookieJar,
        protected Recaller $recaller
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

    public function attempt(string $email, string $password, bool $remember = false): bool
    {
        $user = $this->getUserBy('email', $email);

        if (!$user || !$this->hasValidCredentials($user, $password)) {
            return false;
        }

        if ($this->hasher->needsRehash($user->password)) {
            $this->rehashPassword($user, $password);
        }

        $this->setUserSession($user);

        if ($remember) {
            $this->setRememberToken($user);
        }

        return true;
    }

    public function logout(): void
    {
        $this->cookieJar->clear(self::REMEMBER_COOKIE_KEY);
        $this->session->clear(self::AUTH_SESSION_KEY);
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

    public function setUserFromCookie(): void
    {
        [$identifier, $plainToken] = $this->recaller->splitCookieValue(
            $this->cookieJar->get(self::REMEMBER_COOKIE_KEY)
        );

        $user = $this->db->getRepository(User::class)->findOneBy([
            'remember_identifier' => $identifier
        ]);

        if (!$user) {
            $this->cookieJar->clear(self::REMEMBER_COOKIE_KEY);
        }

        if (!$this->recaller->validateToken($plainToken, $user->remember_token)) {

            $user->update([
                'remember_identifier' => null,
                'remember_token' => null
            ]);
            $this->db->flush();

            $this->cookieJar->clear(self::REMEMBER_COOKIE_KEY);

            throw new Exception();
        }

        $this->setUserSession($user);
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

    protected function setRememberToken(User $user): void
    {
        [$identifier, $token] = $this->recaller->generate();

        $this->cookieJar->set(self::REMEMBER_COOKIE_KEY, $this->recaller->generateValueForCookie($identifier, $token));

        $user->update([
            'remember_identifier' => $identifier,
            'remember_token' => $this->recaller->getTokenHashForDatabase($token),
        ]);

        $this->db->flush();
    }

    public function hasRecaller(): bool
    {
        return $this->cookieJar->exists(self::REMEMBER_COOKIE_KEY);
    }
}
