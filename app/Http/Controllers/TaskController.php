<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('project_id', $request->project_id)->orderBy('priority')->get();
        $projects = Project::all();
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'priority' => 'required|integer',
            'project_id' => 'required|exists:projects,id',
        ]);

        Task::create($data);
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
        foreach ($request->order as $index => $id) {
            Task::where('id', $id)->update(['priority' => $index + 1]);
        }
        return response()->json(['status' => 'success']);
    }
}
