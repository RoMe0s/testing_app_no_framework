<?php

namespace App;

class FileHelper
{
    public static function rootPath(string $path = ''): string
    {
        return getcwd() . '/' . ltrim($path, '/');
    }

    public static function viewPath(string $view): string
    {
        return static::rootPath('views/' . $view . '.php');
    }
}