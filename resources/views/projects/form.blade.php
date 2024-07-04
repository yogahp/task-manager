@extends('layouts.app')

@section('title', isset($project) ? 'Edit Project' : 'Create Project')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>{{ isset($project) ? 'Edit Project' : 'Create Project' }}</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}">
                    @csrf
                    @if(isset($project))
                        @method('PUT')
                    @endif
                    <div class="form-group mb-4">
                        <label for="name">Project Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ isset($project) ? $project->name : '' }}" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            <i class="fas {{ isset($project) ? 'fa-save' : 'fa-plus' }}"></i>
                            {{ isset($project) ? 'Update Project' : 'Create Project' }}
                        </button>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
