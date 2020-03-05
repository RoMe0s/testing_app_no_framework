<?php

namespace App;

final class Application
{
    private static ?Application $instance = null;

    private IoC $container;

    private function __construct()
    {
        $containerConfiguration = require_once FileHelper::rootPath('container.php');

        $this->container = new IoC(
            $containerConfiguration['aliases'] ?? [],
            $containerConfiguration['bindings'] ?? []
        );

        $this->container->set(Configuration::createFromConfig());
    }

    public static function boot(): void
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
    }

    public static function set(object $object, string $alias = null): void
    {
        static::$instance->container->set($object, $alias);
    }

    public static function bind(string $abstract, string $concrete): void
    {
        static::$instance->container->bind($abstract, $concrete);
    }

    public static function get(string $key)
    {
        return static::$instance->container->get($key);
    }

    public static function composeClass(string $class, array $parameterBag = []): object
    {
        return static::$instance->container->composeClass($class, $parameterBag);
    }

    public static function composeMethod(object $object, string $method, array $parameterBag = [])
    {
        return static::$instance->container->composeMethod($object, $method, $parameterBag);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}