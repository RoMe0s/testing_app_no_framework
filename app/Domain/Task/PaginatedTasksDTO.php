<?php

namespace Domain\Task;

class PaginatedTasksDTO
{
    public int $page;
    public int $pagesCount;
    public int $perPage;
    public array $tasks;

    public function __construct(int $page, int $pagesCount, int $perPage, array $tasks)
    {
        $this->page = $page;
        $this->pagesCount = $pagesCount;
        $this->perPage = $perPage;
        $this->tasks = $tasks;
    }
}