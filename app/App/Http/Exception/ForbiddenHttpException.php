<?php

namespace App\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

class ForbiddenHttpException extends HttpException
{
    public function getStatus(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}