@extends('app')

@section('title', 'Task Details')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center text-primary">Task Details</h1>

    <div class="card border-light shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">{{ $task->title }}</h5>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Status: {{ ucfirst($task->status) }}</h6>
            <p class="card-text">{{ $task->description }}</p>
            <p class="card-text">
                <strong>Start Date:</strong> {{ $task->start_date ? $task->start_date->format('F j, Y g:i A') : 'N/A' }}<br>
                <strong>End Date:</strong> {{ $task->end_date ? $task->end_date->format('F j, Y g:i A') : 'N/A' }}
            </p>
            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/task-details.css') }}">
@endsection
