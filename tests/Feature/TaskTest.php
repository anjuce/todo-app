<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/tasks', [
                'title' => 'Test Task',
                'description' => 'This is a test task',
                'priority' => 'low',
                'status' => 'pending',
            ])
            ->assertStatus(201);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put("/tasks/{$task->id}", [
                'title' => 'Updated Task',
                'description' => 'Updated description',
                'priority' => 'medium',
                'status' => 'in_progress',
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['title' => 'Updated Task']);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete("/tasks/{$task->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_edit_or_delete_other_users_tasks()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->put("/tasks/{$task->id}", ['title' => 'Hacked Task'])
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete("/tasks/{$task->id}")
            ->assertStatus(403);
    }

}
