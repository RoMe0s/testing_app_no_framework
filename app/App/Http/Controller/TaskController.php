<?php

namespace App\Http\Controller;

use App\Http\FormRequest\StoreTaskRequest;
use App\Http\FormRequest\UpdateTaskRequest;
use App\StringHelper;
use Domain\Task\TaskService;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $page = $request->get('page', 1);

        $paginatedTasks = $this->taskService->paginate(
            $page,
            StringHelper::convertSnakeCaseToCamelCase($request->get('sort_by', 'user_email')),
            $request->get('sort_type', 'asc')
        );

        if ($paginatedTasks->pagesCount && $page > $paginatedTasks->pagesCount) {
            $this->throwNotFound();
        }

        return $this->view('index', [
            'page' => $paginatedTasks->page,
            'pagesCount' => $paginatedTasks->pagesCount,
            'tasks' => $paginatedTasks->tasks,
        ]);
    }

    public function create()
    {
        return $this->view('task_create');
    }

    public function store(StoreTaskRequest $request)
    {
        $this->taskService->store($request->getDTO());
        return $this->redirect('/');
    }

    public function edit(int $id)
    {
        $task = $this->taskService->findTask($id);

        if (is_null($task)) {
            $this->throwNotFound();
        }

        return $this->view('edit_task', compact('task'));
    }

    public function update(int $id, UpdateTaskRequest $request)
    {
        $task = $this->taskService->findTask($id);

        if (is_null($task)) {
            $this->throwNotFound();
        }

        $this->taskService->update($task, $request->getDTO());

        return $this->redirectBack();
    }
}