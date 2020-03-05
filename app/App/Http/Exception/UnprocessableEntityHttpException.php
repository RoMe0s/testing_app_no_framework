<?php

namespace App\Http\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UnprocessableEntityHttpException extends HttpException
{
    private array $errors;

    public function __construct(array $errors, $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($code, $previous);
    }

    public function getStatus(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}