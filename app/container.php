<?php

return [
    'aliases' => [
        'config' => \App\Configuration::class,
        'em' => \Doctrine\ORM\EntityManager::class,
        \Doctrine\ORM\EntityManagerInterface::class => \Doctrine\ORM\EntityManager::class,
        'request' => \Symfony\Component\HttpFoundation\Request::class,
        'router' => \App\Http\Router::class,
    ],
    'bindings' => [
        \Domain\User\UserRepository::class => \App\User\UserRepository::class,
        \Domain\Task\TaskRepository::class => \App\Task\TaskRepository::class,
        \Domain\User\PasswordService::class => \App\User\PasswordService::class,
    ]
];
