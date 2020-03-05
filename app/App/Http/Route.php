<?php

namespace App\Http;

use App\Http\Exception\ActionIsMissedException;
use App\Http\Exception\WrongMiddlewareClassException;
use App\Http\Middleware\Middleware;
use Symfony\Component\HttpFoundation\Request;

class Route
{
    private string $type;
    private string $path;
    private string $controller;
    private string $method;
    private array $middleware;

    private function __construct(string $type, string $path, string $controller, string $method, array $middleware = [])
    {
        if (false === method_exists($controller, $method)) {
            throw new ActionIsMissedException("$controller@$method(path:$path)");
        }

        foreach ($middleware as $middlewareClass) {
            if (false === is_subclass_of($middlewareClass, Middleware::class)) {
                throw new WrongMiddlewareClassException($middlewareClass);
            }
        }

        $this->type = $type;
        $this->path = $path;
        $this->controller = $controller;
        $this->method = $method;
        $this->middleware = $middleware;
    }

    public static function get(string $path, string $controller, string $method, array $middleware = []): self
    {
        return static::register(Request::METHOD_GET, $path, $controller, $method, $middleware);
    }

    public static function post(string $path, string $controller, string $method, array $middleware = []): self
    {
        return static::register(Request::METHOD_POST, $path, $controller, $method, $middleware);
    }

    public static function register(string $type, string $path, string $controller, string $method, array $middleware = []): self
    {
        return new static($type, $path, $controller, $method, $middleware);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}