<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Repository\TaskRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeTask
{
    private TaskRepository $taskRepository;

    public function __construct(
        TaskRepository       $taskRepository
    )
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            throw new \Exception('User Not found');
        }

        try {
            $taskId = (int)$request->route('taskId');

            $task = $this->taskRepository->findById($taskId);
            if (!$task) {
                throw new \Exception('Task not found');
            }
            if (Auth::id() !== $task->user_id) {
                throw new \Exception('You can not change this task');
            }

            return $next($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

}
