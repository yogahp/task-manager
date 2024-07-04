@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Create Task</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name">Task Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="priority">Priority</label>
                        <input type="number" class="form-control" id="priority" name="priority" value="{{ $lastPriority }}" disabled>
                    </div>
                    <div class="form-group mb-4">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control" required>
                            <option value="">- Select Project -</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create Task
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
