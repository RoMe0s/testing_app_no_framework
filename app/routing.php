<?php

use App\Http\Route;

return [
    Route::get('/', \App\Http\Controller\TaskController::class, 'index'),
    Route::get('/tasks/create', \App\Http\Controller\TaskController::class, 'create'),
    Route::post('/tasks', \App\Http\Controller\TaskController::class, 'store'),
    Route::get('/tasks/{id}/edit', \App\Http\Controller\TaskController::class, 'edit', [
        \App\Http\Middleware\AuthenticatedMiddleware::class,
    ]),
    Route::post('/tasks/{id}/update', \App\Http\Controller\TaskController::class, 'update', [
        \App\Http\Middleware\AuthenticatedMiddleware::class,
    ]),

    Route::get('/login', \App\Http\Controller\LoginController::class, 'loginView', [
        \App\Http\Middleware\GuestMiddleware::class,
    ]),
    Route::post('/login', \App\Http\Controller\LoginController::class, 'login', [
        \App\Http\Middleware\GuestMiddleware::class,
    ]),

    Route::post('/logout', \App\Http\Controller\LoginController::class, 'logout', [
        \App\Http\Middleware\AuthenticatedMiddleware::class,
    ]),

    /** Not a part of the testing app */
    Route::get('/fixture/user', \App\Http\Controller\UserFixtureController::class, 'index'),
];
