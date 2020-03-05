<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\Request;
use App\FileHelper;

class Router
{
    private array $routesMap = [];

    private function __construct(array $routesMap)
    {
        $this->routesMap = $routesMap;
    }

    public static function createFromConfig(): Router
    {
        $routesMap = require FileHelper::rootPath('routing.php');
        return new static($routesMap);
    }

    public function findAction(Request $request): ?Action
    {
        /** @var Route $route */
        foreach ($this->routesMap as $route) {
            $typeRegex = "@^{$request->getMethod()}$@i";

            if (preg_match($typeRegex, $route->getType())) {
                $pathRegex = trim(preg_replace('@{.*}@U', '(.+)', $route->getPath()), '/');

                if (preg_match_all("@^$pathRegex$@", trim($request->getPathInfo(), '/'), $attributes)) {
                    if (count($attributes) === 2) {
                        preg_match_all("@{(.+)}@U", $route->getPath(), $attributeNames);
                        $routeParameters = array_combine($attributeNames[1], $attributes[1]);
                    }

                    return new Action(
                        $route->getController(),
                        $route->getMethod(),
                        $route->getMiddleware(),
                        $routeParameters ?? []
                    );
                }
            }
        }
        return null;
    }
}