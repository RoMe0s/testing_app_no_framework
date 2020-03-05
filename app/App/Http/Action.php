<?php

namespace App\Http;

class Action
{
    public string $controller;
    public string $method;
    public array $middleware;
    public array $routeParameters;

    public function __construct(string $controller, string $method, array $middleware = [], array $routeParameters = [])
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->middleware = $middleware;
        $this->routeParameters = $routeParameters;
    }
}