<?php

namespace App\Domain\Repository;

use App\Domain\DTO\TaskDTO;
use App\Models\Task;
use App\Contract\Repository\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @param array $filters
     * @param array $sorts
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTasks(array $filters, array $sorts, int $userId)
    {
        $query = Task::query()->where('user_id', $userId);

        // add filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // add filter by priority
        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        // add sort by created_at, completed_at
        foreach ($sorts as $sort) {
            $direction = 'asc';
            if (str_starts_with($sort, '-')) {
                $direction = 'desc';
                $sort = ltrim($sort, '-');
            }
            $query->orderBy($sort, $direction);
        }
        $tasks = $query->get()->toArray();

        $buildTree = function ($parentId = null) use (&$buildTree, $tasks) {
            $tree = [];
            foreach ($tasks as $task) {
                if ($task['parent_id'] === $parentId) {
                    $children = $buildTree($task['id']);
                    if ($children) {
                        $task['children'] = $children;
                    }
                    $tree[] = $task;
                }
            }
            return $tree;
        };

        return $buildTree();
    }

    /**
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    /**
     * @param TaskDTO $taskDTO
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function createTask(TaskDTO $taskDTO)
    {
        return Task::query()->create([
            'title' => $taskDTO->title,
            'user_id' => $taskDTO->userId,
            'description' => $taskDTO->description,
            'status' => $taskDTO->status,
            'priority' => $taskDTO->priority,
            'parent_id' => $taskDTO->parentId,
        ]);
    }

    /**
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task)
    {
        $task->delete();
    }

    /**
     * @param Task $task
     * @return void
     */
    public function saveTask(Task $task)
    {
        $task->save();
    }
}
