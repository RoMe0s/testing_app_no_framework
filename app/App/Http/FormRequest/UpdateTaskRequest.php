<?php

namespace App\Http\FormRequest;

use App\Http\Auth;
use App\Validation\In;
use App\Validation\Max;
use App\Validation\Required;
use Domain\Task\Task;
use Domain\Task\UpdateTaskDTO;

class UpdateTaskRequest extends FormRequest
{
    protected function getRules(): array
    {
        return [
            'description' => [Required::class, Max::class => ['length' => 1000]],
            'status' => [Required::class, In::class => ['allowed' => [Task::STATUS_NEW, Task::STATUS_DONE]]],
        ];
    }

    public function getDTO(): UpdateTaskDTO
    {
        return new UpdateTaskDTO($this->status, $this->description, Auth::user());
    }
}