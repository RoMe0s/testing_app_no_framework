<?php

namespace App;

final class StringHelper
{
    public static function convertSnakeCaseToCamelCase(string $string): string
    {
        $str = str_replace('_', '', ucwords($string, '_'));
        return lcfirst($str);
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