<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_and_list_tasks()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/tasks', [
                'title' => 'My Task',
                'description' => 'Details',
                'status' => 'pending'
            ])->assertStatus(201)->assertJsonFragment(['title' => 'My Task']);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => ['id', 'title', 'description', 'status', 'user_id', 'created_at', 'updated_at']
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'path',
                'per_page',
                'to',
                'total'
            ]);
    }
}
