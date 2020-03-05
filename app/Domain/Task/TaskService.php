<?php

namespace Domain\Task;

class TaskService
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function paginate(int $page, string $sortBy, string $sortType): PaginatedTasksDTO
    {
        $sortBy = in_array($sortBy, ['userEmail', 'userName', 'status']) ? $sortBy : 'userEmail';
        $sortType = in_array(mb_strtolower($sortType), ['asc', 'desc']) ? $sortType : 'asc';

        $paginator = $this->taskRepository->paginate($sortBy, $sortType);

        $perPage = 3;
        $totalItems = $paginator->count();
        $pagesCount = (int)ceil($totalItems / $perPage);

        $tasks = $paginator->getQuery()
            ->setFirstResult($perPage * ($page - 1))
            ->setMaxResults($perPage)
            ->getResult();

        return new PaginatedTasksDTO($page, $pagesCount, $perPage, $tasks);
    }

    public function findTask(int $id): ?Task
    {
        return $this->taskRepository->findTask($id);
    }

    public function store(StoreTaskDTO $taskDTO): Task
    {
        $task = new Task();
        $task->setUserName($taskDTO->userName)
            ->setUserEmail($taskDTO->userEmail)
            ->setDescription($taskDTO->description);

        $this->taskRepository->save($task);
        return $task;
    }

    public function update(Task $task, UpdateTaskDTO $taskDTO): void
    {
        $task->setDescription($taskDTO->description)
            ->setStatus($taskDTO->status)
            ->setAdmin($taskDTO->user);

        $this->taskRepository->save($task);
    }
}