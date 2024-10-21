<?php

namespace App\Contract\Repository;

use App\Domain\DTO\TaskDTO;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getTasks(array $filters, array $sorts, int $userId);
    public function createTask(TaskDTO $task);
    public function deleteTask(Task $task);
    public function saveTask(Task $task);
}
