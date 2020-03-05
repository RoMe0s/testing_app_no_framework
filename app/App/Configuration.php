<?php

namespace App;

final class Configuration
{
    public const DEV_ENV = 'dev';
    public const PROD_ENV = 'prod';

    private static ?Configuration $instance = null;

    private array $configuration;

    private function __construct(array $configuration = [])
    {
        $this->configuration = $configuration;
    }

    public static function createFromConfig(): Configuration
    {
        if (is_null(static::$instance)) {
            $configuration = require FileHelper::rootPath('configuration.php');
            static::$instance = new static($configuration);
        }
        return static::$instance;
    }

    public static function get(string $key, $default = null)
    {
        return ArrayHelper::findValue($key, static::$instance->configuration) ?: $default;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}