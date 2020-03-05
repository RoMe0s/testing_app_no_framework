<?php

namespace App\Validation;

class In implements RuleInterface
{
    private array $allowed;

    public function __construct(array $allowed)
    {
        $this->allowed = $allowed;
    }

    public function isValid(string $key, array $data): bool
    {
        return in_array($data[$key] ?? null, $this->allowed);
    }

    public function getMessage(): string
    {
        return 'Attribute %s should be value of: ' . implode(',', $this->allowed);
    }
}