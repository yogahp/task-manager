<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();
        $project_id = $request->query('project_id');
        $tasks = Task::when($project_id, function ($query, $project_id) {
            return $query->where('project_id', $project_id);
        })->orderBy('priority')->get();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create()
    {
        $projects = Project::all();
        $lastPriority = Task::max('priority') + 1; // Get the next priority value
        return view('tasks.create', compact('projects', 'lastPriority'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task = new Task();
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->priority = Task::max('priority') + 1; // Set priority to the next available value
        $task->save();

        return redirect()->route('tasks.index', ['project_id' => $request->project_id]);
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required',
            'priority' => 'required|integer',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task->update($data);
        return redirect()->route('tasks.index', ['project_id' => $task->project_id]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index', ['project_id' => $task->project_id]);
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $priority => $id) {
            $task = Task::find($id);
            $task->priority = $priority + 1; // Priority starts at 1
            $task->save();
        }

        return response()->json(['status' => 'success']);
    }
}
