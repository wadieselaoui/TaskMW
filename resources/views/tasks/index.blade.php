@extends('app')

@section('title', 'Tasks')

@section('content')
    <div class="container">
        <h1 class="mb-4">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>
                                <span class="badge {{ $task->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->start_date ? $task->start_date->format('M d, Y H:i') : 'N/A' }}</td>
                            <td>{{ $task->end_date ? $task->end_date->format('M d, Y H:i') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                                @if ($task->status !== 'completed')
    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-success btn-sm"
            onclick="return confirm('Are you sure you want to mark this task as completed?')">Complete</button>
    </form>
@endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
