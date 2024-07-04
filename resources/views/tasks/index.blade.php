@extends('layouts.app')

@section('title', 'Task Management')

@section('content')
    <h1>Task Management</h1>
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
        <div class="form-group">
            <select name="project_id" id="project_id" class="form-control" onchange="this.form.submit()">
                <option value="">- Select Project -</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
    </div>

    <ul id="sortable" class="list-group">
        @foreach($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $task->id }}">
                <span class="handle">&#9776;</span>
                <span>{{ $task->name }}</span>
                <div>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-info">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection

@section('scripts')
    <script>
        $(function() {
            $("#sortable").sortable({
                handle: ".handle",
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $.post('{{ route("tasks.reorder") }}', {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    });
                }
            });
            $("#sortable").disableSelection();
        });
    </script>
@endsection
