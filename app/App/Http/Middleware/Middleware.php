<?php

namespace App\Http\Middleware;

use App\Http\Exception\ForbiddenHttpException;
use Symfony\Component\HttpFoundation\Request;

abstract class Middleware
{
    public static function ensureRequestIsAllowed(Request $request): void
    {
        if (false === static::authorize($request))  {
            $exceptionClass = static::getExceptionClass();

            throw new $exceptionClass;
        }
    }

    abstract protected static function authorize(Request $request): bool;

    protected static function getExceptionClass(): string
    {
        return ForbiddenHttpException::class;
    }
}