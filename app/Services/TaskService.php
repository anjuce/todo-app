<?php

namespace App\Services;

use App\Domain\DTO\TaskDTO;
use App\Models\Task;
use App\Contract\Repository\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;

    /**
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param array $filters
     * @param array $sorts
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTasks(array $filters, array $sorts, int $userId)
    {
        return $this->taskRepository->getTasks($filters, $sorts, $userId);
    }

    /**
     * @param TaskDTO $taskDTO
     * @return mixed
     */
    public function createTask(TaskDTO $taskDTO)
    {
        return $this->taskRepository->createTask($taskDTO);
    }

    /**
     * @param int $taskId
     * @param TaskDTO $taskDTO
     * @return Task
     * @throws \Exception
     */
    public function updateTask(int $taskId, TaskDTO $taskDTO)
    {
        $task = $this->taskRepository->findById($taskId);
        if (!$task) {
            throw new \Exception('Task not found');
        }

        $task->fill($taskDTO->toArray());
        $task->save();

        return $task;
    }

    /**
     * @param int $taskId
     * @return void
     * @throws \Exception
     */
    public function deleteTask(int $taskId)
    {
        $task = $this->taskRepository->findById($taskId);
        if (!$task) {
            throw new \Exception('Task not found');
        }

        $this->taskRepository->deleteTask($task);
    }

    /**
     * @param int $taskId
     * @return Task|null
     * @throws \Exception
     */
    public function findById(int $taskId): ?Task
    {
        $task = $this->taskRepository->findById($taskId);
        if (!$task) {
            throw new \Exception('Task not found');
        }

        return $task;
    }
}
