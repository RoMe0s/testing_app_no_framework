<?php

namespace App\Http\Middleware;

use App\Http\Auth;
use App\Http\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Request;

class AuthenticatedMiddleware extends Middleware
{
    public static function authorize(Request $request): bool
    {
        return Auth::authenticated();
    }

    public static function getExceptionClass(): string
    {
        return UnauthorizedHttpException::class;
    }
}