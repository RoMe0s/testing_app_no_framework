<?php

namespace App\Validation;

class Max implements RuleInterface
{
    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function isValid(string $key, array $data): bool
    {
        return mb_strlen($data[$key] ?? '') <= $this->length;
    }

    public function getMessage(): string
    {
        return "Attribute %s should equal or less then {$this->length} characters.";
    }
}