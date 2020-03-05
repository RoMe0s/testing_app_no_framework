<?php

namespace Domain\Task;

class StoreTaskDTO
{
    public string $userName;
    public string $userEmail;
    public string $description;

    public function __construct(string $userName, string $userEmail, string $description)
    {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->description = $description;
    }
}