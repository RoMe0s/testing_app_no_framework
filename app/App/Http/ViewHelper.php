<?php

namespace App\Http;

use App\Application;
use Symfony\Component\HttpFoundation\Request;

final class ViewHelper
{
    public static function buildUrlKeepingGetParams(array $paramsToReplace): string
    {
        /** @var Request $request */
        $request = Application::get('request');
        $params = array_merge($request->query->all(), $paramsToReplace);

        return empty($params)
            ? $request->getPathInfo()
            : $request->getPathInfo() . '?' . http_build_query($params);
    }

    public static function csrtTokenInput(): string
    {
        return '<input type="hidden" name="' . static::csrfTokenName() . '" value="' . static::csrfToken() . '">';
    }

    public static function csrfTokenName(): string
    {
        return CSRFProtection::CSRF_TOKEN_REQUEST_KEY;
    }

    public static function csrfToken(): string
    {
        return CSRFProtection::token();
    }

    public static function getOldInput(string $key, $default = null)
    {
        $oldInputValue = Session::get("old_input.$key", $default);
        return is_string($oldInputValue) ? static::safeHTML($oldInputValue) : $oldInputValue;
    }

    public static function safeHTML(string $html): string
    {
        return htmlentities(htmlspecialchars($html, ENT_QUOTES));
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