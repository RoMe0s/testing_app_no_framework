<?php

namespace Domain\Task;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface TaskRepository
{
    public function paginate(string $orderBy, string $orderType): Paginator;

    public function findTask(int $id): ?Task;

    public function save(Task $task): void;
}