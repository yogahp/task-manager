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
        $lastPriority = Task::max('priority') + 1;
        return view('tasks.form', compact('projects', 'lastPriority'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        Task::create([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'priority' => Task::max('priority') + 1,
        ]);

        return redirect()->route('tasks.index', ['project_id' => $request->project_id]);
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.form', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $task->update($request->only(['name', 'project_id']));

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
            $task->priority = $priority + 1;
            $task->save();
        }

        return response()->json(['status' => 'success']);
    }
}
