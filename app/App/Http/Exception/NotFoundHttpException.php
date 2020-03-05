<?php

namespace App\Http\Exception;

use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpException extends HttpException
{
    public function getStatus(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}