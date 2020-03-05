<?php

namespace Domain\Task;

use Domain\User\User;

class UpdateTaskDTO
{
    public string $status;
    public string $description;
    public User $user;

    public function __construct(string $status, string $description, User $user)
    {
        $this->status = $status;
        $this->description = $description;
        $this->user = $user;
    }
}