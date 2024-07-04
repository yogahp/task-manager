@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Create Task')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>{{ isset($task) ? 'Edit Task' : 'Create Task' }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($task) ? route('tasks.update', $task->id) : route('tasks.store') }}">
                    @csrf
                    @if(isset($task))
                        @method('PUT')
                    @endif
                    <div class="form-group mb-4">
                        <label for="name">Task Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ isset($task) ? $task->name : '' }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="priority">Priority</label>
                        <input type="number" class="form-control" id="priority" name="priority" value="{{ isset($task) ? $task->priority : $lastPriority }}" disabled>
                    </div>
                    <div class="form-group mb-4">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control" required>
                            <option value="">- Select Project -</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ isset($task) && $task->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="fas {{ isset($task) ? 'fa-save' : 'fa-plus' }}"></i>
                            {{ isset($task) ? 'Update Task' : 'Create Task' }}
                        </button>
                        <a href="{{ route('tasks.index', isset($task) ? ['project_id' => $task->project_id] : []) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
