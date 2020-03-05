<?php

namespace App\Http\FormRequest;

use App\Validation\Email;
use App\Validation\Required;

/**
 * @property string $email
 * @property string $password
 */
class LoginRequest extends FormRequest
{
    protected function getRules(): array
    {
        return [
            'email' => [Required::class, Email::class],
            'password' => Required::class,
        ];
    }
}