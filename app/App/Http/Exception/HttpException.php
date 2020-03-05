<?php

namespace App\Http\Exception;

use Throwable;
use Symfony\Component\HttpFoundation\Response;

abstract class HttpException extends \Exception
{
    abstract public function getStatus(): int;

    public function __construct($code = 0, Throwable $previous = null)
    {
        return parent::__construct($this->getResponseMessage(), $code, $previous);
    }

    public function getResponseMessage(): ?string
    {
        return Response::$statusTexts[$this->getStatus()] ?? null;
    }
}