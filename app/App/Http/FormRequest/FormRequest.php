<?php

namespace App\Http\FormRequest;

use App\Http\Exception\UnprocessableEntityHttpException;
use App\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

abstract class FormRequest
{
    private Request $request;

    abstract protected function getRules(): array;

    protected function validate(Request $request): array
    {
        return Validator::validate($request->request->all(), $this->getRules());
    }

    final public function __construct(Request $request)
    {
        if ($errors = $this->validate($request)) {
            throw new UnprocessableEntityHttpException($errors);
        }

        $this->request = $request;
    }

    final public function all(): array
    {
        return $this->request->request->all();
    }

    public function __get($name)
    {
        return $this->request->request->get($name);
    }
}