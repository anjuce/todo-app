<?php

namespace App\Domain\DTO;

class TaskDTO
{
    public string $title;
    public int $userId;
    public ?string $description;
    public ?string $priority;
    public ?string $status;
    public ?int $parentId;
    public ?string $createdAt;
    public ?string $completedAt;

    public function __construct(string $title, int $userId, ?string $description, ?string $priority, ?string $status = null, ?int $parentId = null, ?string $createdAt = null, ?string $completedAt = null)
    {
        $this->title = $title;
        $this->userId = $userId;
        $this->description = $description;
        $this->priority = $priority;
        $this->status = $status;
        $this->parentId = $parentId;
        $this->createdAt = $createdAt;
        $this->completedAt = $completedAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
        ];
    }
}
