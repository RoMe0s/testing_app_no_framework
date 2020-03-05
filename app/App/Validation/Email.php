<?php

namespace App\Validation;

class Email implements RuleInterface
{
    public function isValid(string $key, array $data): bool
    {
        return (bool)filter_var($data[$key] ?? '', FILTER_VALIDATE_EMAIL);
    }

    public function getMessage(): string
    {
        return 'Attribute %s should be right email.';
    }
}