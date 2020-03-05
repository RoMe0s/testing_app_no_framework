<?php

namespace Domain\User;

class UserService
{
    private UserRepository $userRepository;
    private PasswordService $passwordService;

    public function __construct(UserRepository $userRepository, PasswordService $passwordService)
    {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
    }

    public function authenticate(string $email, string $password): ?User
    {
        if (
            ($user = $this->userRepository->findUserByEmail($email))
            && $this->passwordService->compare($password, $user->getPassword())
        ) {
            return $user;
        }

        return null;
    }
}