<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class IndexTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'sort_by' => 'sometimes|array',
            'sort_by.*' => 'in:createdAt,completedAt,-createdAt,-completedAt',

            'status' => 'nullable|in' . implode(',', TaskStatus::values()),
            'priority' => 'nullable|in' . implode(',', TaskPriority::values()),
        ];
    }
}
