<?php

namespace App\Http;

use App\Application;
use App\Configuration;
use App\Http\Exception\ForbiddenHttpException;
use Symfony\Component\HttpFoundation\Request;

final class CSRFProtection
{
    public const CSRF_TOKEN_REQUEST_KEY = 'csrf-token';

    private const HTTP_REQUEST_TYPES_WITH_CSRF_TOKEN_IN_THE_REQUEST_BODY = [
        Request::METHOD_POST,
    ];

    private static ?string $csrfToken = null;

    public static function boot(): void
    {
        if (is_null(static::$csrfToken)) {
            $token = Session::get(static::CSRF_TOKEN_REQUEST_KEY);
            if (is_null($token)) {
                $token = password_hash(Configuration::get('app_key'), PASSWORD_DEFAULT);

                Session::setCookie(
                    static::CSRF_TOKEN_REQUEST_KEY,
                    $token,
                    time() + (3600 * 12) //12 hours
                );
            }

            static::$csrfToken = $token;
        }
    }

    public static function token(): string
    {
        return static::$csrfToken;
    }

    public static function ensureRequestIsAllowed(): void
    {
        $request = Application::get('request');

        if (
            in_array($request->getMethod(), static::HTTP_REQUEST_TYPES_WITH_CSRF_TOKEN_IN_THE_REQUEST_BODY)
            && (
                !($token = $request->request->get(static::CSRF_TOKEN_REQUEST_KEY))
                || $token !== static::token()
                || !password_verify(Configuration::get('app_key'), $token)
            )
        ) {
            Session::remove(static::CSRF_TOKEN_REQUEST_KEY);

            throw new ForbiddenHttpException();
        }
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}