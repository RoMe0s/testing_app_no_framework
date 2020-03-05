<?php

namespace App\Http\Controller;

use App\Http\Auth;
use App\Http\Exception\UnprocessableEntityHttpException;
use App\Http\FormRequest\LoginRequest;
use Domain\User\UserService;

class LoginController extends Controller
{
    public function loginView()
    {
        return $this->view('login');
    }

    public function login(LoginRequest $loginRequest, UserService $userService)
    {
        $user = $userService->authenticate($loginRequest->email, $loginRequest->password);

        if (is_null($user)) {
            throw new UnprocessableEntityHttpException(['auth' => ['Login or password is wrong.']]);
        }

        Auth::setUser($user);

        return $this->redirect('/');
    }

    public function logout()
    {
        Auth::forgetUser();

        return $this->redirect('/');
    }
}