<?php

namespace App\Http\Middleware;

use App\Http\Auth;
use Symfony\Component\HttpFoundation\Request;

class GuestMiddleware extends Middleware
{
    public static function authorize(Request $request): bool
    {
        return false === Auth::authenticated();
    }
}