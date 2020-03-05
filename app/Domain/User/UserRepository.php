<?php

namespace Domain\User;

interface UserRepository
{
    public function findUserById(int $id): ?User;

    public function findUserByEmail(string $email): ?User;
}