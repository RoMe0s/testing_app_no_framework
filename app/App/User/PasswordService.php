<?php

namespace App\User;

use Domain\User\PasswordService as PasswordServiceInterface;

class PasswordService implements PasswordServiceInterface
{
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function compare(string $password, string $expected): bool
    {
        return password_verify($password, $expected);
    }
}