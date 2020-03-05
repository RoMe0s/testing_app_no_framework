<?php

namespace Domain\User;

interface PasswordService
{
    public function hashPassword(string $password): string;

    public function compare(string $password, string $expected): bool;
}