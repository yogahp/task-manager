@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Project
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projects.update', $project) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Project Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Project</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
