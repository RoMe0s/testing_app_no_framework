<?php

namespace App\Validation;

class Required implements RuleInterface
{
    public function isValid(string $key, array $data): bool
    {
        return array_key_exists($key, $data) && false === empty($data[$key]);
    }

    public function getMessage(): string
    {
        return 'Attribute %s is required.';
    }
}