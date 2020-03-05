<?php

namespace App\Http\Controller;

use App\Application;
use App\Http\Exception\NotFoundHttpException;
use App\Http\Session;
use App\Http\ViewResponseFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public static function callMethod(string $method, array $routeParameters): Response
    {
        $instance = Application::composeClass(static::class);

        return Application::composeMethod($instance, $method, $routeParameters);
    }

    public function view(string $view, array $data = [], int $status = 200, array $headers = []): Response
    {
        return ViewResponseFactory::createResponse($view, $data, $status, $headers);
    }

    public function redirect(string $url, int $status = 302, array $headers = []): Response
    {
        return new RedirectResponse($url, $status, $headers);
    }

    public function redirectBack(int $status = 302, array $headers = []): Response
    {
        return new RedirectResponse(Session::getPreviousUrl(), $status, $headers);
    }

    public function throwNotFound()
    {
        throw new NotFoundHttpException();
    }
}