<?php

namespace App\Http;

use App\Application;
use App\Configuration;
use Domain\User\User;
use Domain\User\UserRepository;

final class Auth
{
    private const AUTH_SESSION_COOKIE_NAME = 'auth_session';

    private static ?Auth $instance = null;

    private ?User $user = null;

    private function __construct()
    {
        $this->obtainUserFromCookie(Application::composeClass(UserRepository::class));
    }

    public static function boot(): void
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
    }

    public static function user(): ?User
    {
        return static::$instance->user;
    }

    public static function authenticated(): bool
    {
        return static::$instance->user instanceof User;
    }

    public static function setUser(User $user): void
    {
        Session::setCookie(
            static::AUTH_SESSION_COOKIE_NAME,
            json_encode([$user->getId(), static::$instance->hashUserData($user)])
        );
    }

    public static function forgetUser(): void
    {
        Session::remove(static::AUTH_SESSION_COOKIE_NAME);
    }

    private function obtainUserFromCookie(UserRepository $userRepository): void
    {
        $authSession = json_decode(Session::get('auth_session'));
        if (is_array($authSession) && 2 === count($authSession)) {
            [$id, $emailAndPasswordHash] = $authSession;

            if (
                ($user = $userRepository->findUserById($id))
                && hash_equals($this->hashUserData($user), $emailAndPasswordHash)
            ) {
                $this->user = $user;
            } else {
                static::forgetUser();
            }
        }
    }

    private function hashUserData(User $user): string
    {
        return crypt(json_encode($user->getEmail() . $user->getPassword()), Configuration::get('app_key'));
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}