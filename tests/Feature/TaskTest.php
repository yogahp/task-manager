<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTask()
    {
        $project = Project::factory()->create();
        $response = $this->post('/tasks', [
            'name' => 'Test Task',
            'project_id' => $project->id
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['name' => 'Test Task']);
    }

    public function testEditTask()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);
        $response = $this->put('/tasks/' . $task->id, [
            'name' => 'Updated Task',
            'project_id' => $project->id
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task']);
    }

    public function testDeleteTask()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);
        $response = $this->delete('/tasks/' . $task->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
