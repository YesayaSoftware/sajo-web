<?php

namespace Tests\Feature;


use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
     /** @test */
    public function a_user_can_add_task()
    {
        $this->signIn();

        $task = make(Task::class);

        $this->post('/tasks/saveTask', $task->toArray())
            ->assertStatus(202);
    }
}
