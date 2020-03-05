<?php

namespace App\Validation;

interface RuleInterface
{
    public function isValid(string $key, array $data): bool;

    public function getMessage(): string;
}