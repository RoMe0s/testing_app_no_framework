<?php

namespace App\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnauthorizedHttpException extends HttpException
{
    public function getStatus(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}