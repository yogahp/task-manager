<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a sample project for testing
        $this->project = Project::factory()->create();
    }

    public function test_index_displays_tasks()
    {
        $task = Task::factory()->create(['project_id' => $this->project->id]);

        $response = $this->get(route('tasks.index', ['project_id' => $this->project->id]));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks');
        $response->assertSee($task->name);
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.form');
    }

    public function test_store_saves_new_task_and_redirects()
    {
        $response = $this->post(route('tasks.store'), [
            'name' => 'New Task',
            'project_id' => $this->project->id,
        ]);

        $response->assertRedirect(route('tasks.index', ['project_id' => $this->project->id]));
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    public function test_edit_displays_form()
    {
        $task = Task::factory()->create(['project_id' => $this->project->id]);

        $response = $this->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertViewIs('tasks.form');
        $response->assertViewHas('task', $task);
    }

    public function test_update_saves_changes_and_redirects()
    {
        $task = Task::factory()->create(['project_id' => $this->project->id]);

        $response = $this->put(route('tasks.update', $task), [
            'name' => 'Updated Task',
            'project_id' => $this->project->id,
        ]);

        $response->assertRedirect(route('tasks.index', ['project_id' => $this->project->id]));
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task']);
    }

    public function test_destroy_deletes_task_and_redirects()
    {
        $task = Task::factory()->create(['project_id' => $this->project->id]);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index', ['project_id' => $this->project->id]));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_reorder_updates_task_priorities()
    {
        $task1 = Task::factory()->create(['project_id' => $this->project->id, 'priority' => 1]);
        $task2 = Task::factory()->create(['project_id' => $this->project->id, 'priority' => 2]);

        $response = $this->post(route('tasks.reorder'), [
            'order' => [$task2->id, $task1->id],
        ]);

        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('tasks', ['id' => $task1->id, 'priority' => 2]);
        $this->assertDatabaseHas('tasks', ['id' => $task2->id, 'priority' => 1]);
    }
}
