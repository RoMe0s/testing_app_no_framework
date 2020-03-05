<?php

namespace App\Http\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Domain\User\PasswordService;
use Domain\User\User;
use Domain\User\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Not a part of the testing app
 */
class UserFixtureController extends Controller
{
    public function index(PasswordService $passwordService, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $email = 'admin@admin.com';
        $password = 'password';

        $hashedPassword = $passwordService->hashPassword($password);

        $user = $userRepository->findUserByEmail($email) ?: new User();
        $user->setEmail($email)
            ->setPassword($hashedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['login' => $email, 'password' => $password]);
    }
}