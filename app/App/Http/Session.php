<?php

namespace App\Http;

use App\Application;
use App\ArrayHelper;
use App\Configuration;

final class Session
{
    private const STATIC_DATA_SESSION_KEY = 'static_data';
    private const NEXT_REQUEST_ONLY_DATA_SESSION_KEY = 'next_request_only_data';

    private static ?Session $instance = null;

    private array $nextRequestOnlyData = [];

    private function __construct()
    {
        $this->nextRequestOnlyData['previous_url'] = $_SESSION[self::NEXT_REQUEST_ONLY_DATA_SESSION_KEY]['previous_url'] ?? null;
    }

    public static function boot(): void
    {
        if (is_null(static::$instance)) {
            session_name(Configuration::get('app_name'));
            session_start();

            static::$instance = new static();
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[static::STATIC_DATA_SESSION_KEY][$key] = $value;
    }

    public static function setCookie(string $key, $value, int $expire = null): void
    {
        if (is_null($expire)) { //use default lifetime
            $expire = time() + (86400 * 7); //one week
        }

        setcookie($key, $value, $expire, '/');
    }

    public static function setForNextRequestOnly(string $key, $value): void
    {
        static::$instance->nextRequestOnlyData[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        return ArrayHelper::findValue($key, $_SESSION[static::NEXT_REQUEST_ONLY_DATA_SESSION_KEY] ?? [])
            ?: (ArrayHelper::findValue($key, static::$instance->nextRequestOnlyData)
                ?: (ArrayHelper::findValue($key, $_SESSION[static::STATIC_DATA_SESSION_KEY] ?? [])
                    ?: (ArrayHelper::findValue($key, $_COOKIE) ?: $default)));
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[static::NEXT_REQUEST_ONLY_DATA_SESSION_KEY][$key]);
        unset($_SESSION[static::STATIC_DATA_SESSION_KEY][$key]);
        unset(self::$instance->nextRequestOnlyData[$key]);
        setcookie($key, null, time() - 1);
    }

    public static function has(string $key): bool
    {
        return false === is_null(static::get($key));
    }

    public static function terminate(): void
    {
        static::setForNextRequestOnly('previous_url', Application::get('request')->getPathInfo());
        $_SESSION[static::NEXT_REQUEST_ONLY_DATA_SESSION_KEY] = static::$instance->nextRequestOnlyData;
    }

    public static function getPreviousUrl(): string
    {
        return static::get('previous_url', '/');
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}