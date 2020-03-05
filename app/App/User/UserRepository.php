<?php

namespace App\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Domain\User\User;
use Domain\User\UserRepository as UserRepositoryInterface;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(User::class));
    }

    public function findUserById(int $id): ?User
    {
        return $this->find($id);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy(compact('email'));
    }
}