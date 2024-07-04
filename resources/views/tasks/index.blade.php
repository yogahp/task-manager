<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Task Management</h1>
        <form method="GET" action="{{ route('tasks.index') }}">
            <div class="form-group">
                <label for="project_id">Select Project</label>
                <select name="project_id" id="project_id" class="form-control" onchange="this.form.submit()">
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>

        <ul id="sortable" class="list-group mt-3">
            @foreach($tasks as $task)
                <li class="list-group-item" data-id="{{ $task->id }}">
                    {{ $task->name }}
                    <div class="float-right">
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
    </div>

    <script>
        $(function() {
            $("#sortable").sortable({
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
</body>
</html>
