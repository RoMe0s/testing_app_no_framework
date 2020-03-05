<?php

namespace App\Http;

use App\Application;
use App\Configuration;
use App\Http\Exception\ForbiddenHttpException;
use App\Http\Exception\HttpException;
use App\Http\Exception\InternalServerErrorHttpException;
use App\Http\Exception\NotFoundHttpException;
use App\Http\Exception\UnprocessableEntityHttpException;
use App\Http\Exception\UnauthorizedHttpException;
use App\Http\Middleware\Middleware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HttpHandler
{
    public static function handle(): Response
    {
        try {
            CSRFProtection::ensureRequestIsAllowed();

            return static::getResponse();
        } catch (\Throwable $exception) {
            if ($exception instanceof HttpException) {
                switch (get_class($exception)) {
                    case UnprocessableEntityHttpException::class:
                        Session::setForNextRequestOnly('old_input', Application::get('request')->request->all());
                        Session::setForNextRequestOnly('validation_errors', $exception->getErrors());
                    case ForbiddenHttpException::class:
                        return new RedirectResponse(Session::getPreviousUrl());
                    case UnauthorizedHttpException::class:
                        return new RedirectResponse('/login');
                    default:
                        return new Response($exception->getResponseMessage(), $exception->getStatus());
                }
            } else {
                throw $exception;
            }
        }
    }

    private static function getResponse(): Response
    {
        $request = Application::get('request');
        $action = Application::get('router')->findAction($request);

        try {
            if (is_null($action)) {
                throw new NotFoundHttpException();
            }

            /** @var Middleware $middlewareClass */
            foreach ($action->middleware as $middlewareClass) {
                $middlewareClass::ensureRequestIsAllowed($request);
            }

            return $action->controller::callMethod($action->method, $action->routeParameters);
        } catch (HttpException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            if (Configuration::get('env') === Configuration::PROD_ENV) {
                throw new InternalServerErrorHttpException();
            } else {
                throw $exception;
            }
        }
    }
}