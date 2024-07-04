@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <div class="card">
        <div class="card-header">
            Create Project
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Project Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Project</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
