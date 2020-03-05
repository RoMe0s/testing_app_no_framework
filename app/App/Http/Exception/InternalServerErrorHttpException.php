<?php

namespace App\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

class InternalServerErrorHttpException extends HttpException
{
    public function getStatus(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}