<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_projects()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.index');
        $response->assertViewHas('projects');
        $response->assertSee($project->name);
    }

    public function test_create_displays_form()
    {
        $response = $this->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.form');
    }

    public function test_store_saves_new_project_and_redirects()
    {
        $response = $this->post(route('projects.store'), [
            'name' => 'New Project',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', ['name' => 'New Project']);
    }

    public function test_edit_displays_form()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.form');
        $response->assertViewHas('project', $project);
    }

    public function test_update_saves_changes_and_redirects()
    {
        $project = Project::factory()->create();

        $response = $this->put(route('projects.update', $project), [
            'name' => 'Updated Project',
        ]);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', ['name' => 'Updated Project']);
    }

    public function test_destroy_deletes_project_and_redirects()
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
