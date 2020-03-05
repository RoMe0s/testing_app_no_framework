<?php

namespace App\Http\FormRequest;

use App\Validation\Email;
use App\Validation\Max;
use App\Validation\Required;
use Domain\Task\StoreTaskDTO;

class StoreTaskRequest extends FormRequest
{
    protected function getRules(): array
    {
        return [
            'user_name' => [Required::class, Max::class => ['length' => 255]],
            'user_email' => [Required::class, Email::class, Max::class => ['length' => 255]],
            'description' => [Required::class, Max::class => ['length' => 1000]],
        ];
    }

    public function getDTO(): StoreTaskDTO
    {
        return new StoreTaskDTO($this->user_name, $this->user_email, $this->description);
    }
}