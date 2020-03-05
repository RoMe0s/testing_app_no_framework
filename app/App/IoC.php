<?php

namespace App;

use ReflectionClass;
use ReflectionMethod;

class IoC
{
    private array $aliases = [];
    private array $bindings = [];
    private array $dependencies = [];

    function __construct(array $aliases = [], array $bindings = [])
    {
        $this->aliases = $aliases;
        $this->bindings = $bindings;
    }

    public function set(object $object, string $alias = null): void
    {
        $class = get_class($object);
        if ($alias) {
            $this->aliases[$alias] = $class;
        }
        $this->dependencies[$class] = $object;
    }

    public function bind(string $abstract, string $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $key): ?object
    {
        if (array_key_exists($key, $this->aliases)) {
            $key = $this->aliases[$key];
        }
        return $this->dependencies[$key] ?? null;
    }

    public function composeClass(string $class, array $parameterBag = []): object
    {
        if ($builtDependency = $this->get($class)) {
            return $builtDependency;
        }

        if (array_key_exists($class, $this->bindings)) {
            $class = $this->bindings[$class];
        }

        $reflectionClass = new ReflectionClass($class);
        $reflectionConstructor = $reflectionClass->getConstructor();

        if ($reflectionConstructor) {
            $args = [];
            foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
                $parameterName = $parameter->getName();
                if (array_key_exists($parameterName, $parameterBag)) {
                    $args[] = $parameterBag[$parameterName];
                } elseif ($parameterClass = $parameter->getClass()) {
                    $args[] = $this->composeClass($parameterClass->getName());
                } else {
                    throw new UnresolvableDependencyException();
                }
            }
            $object = $reflectionClass->newInstanceArgs($args);
        } else {
            $object = $reflectionClass->newInstanceWithoutConstructor();
        }

        $this->set($object);

        return $object;
    }

    public function composeMethod(object $object, string $method, array $parameterBag = [])
    {
        $reflectionMethod = new ReflectionMethod($object, $method);

        $args = [];
        foreach ($reflectionMethod->getParameters() as $parameter) {
            $parameterName = $parameter->getName();
            if (array_key_exists($parameterName, $parameterBag)) {
                $args[] = $parameterBag[$parameterName];
            } elseif ($parameterClass = $parameter->getClass()) {
                $args[] = $this->composeClass($parameterClass->getName());
            } else {
                throw new UnresolvableDependencyException();
            }
        }
        return $reflectionMethod->invokeArgs($object, $args);
    }
}