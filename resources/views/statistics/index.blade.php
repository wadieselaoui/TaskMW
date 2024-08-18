@extends('app')

@section('title', 'Statistics')

@section('content')
<h1>Task Statistics</h1>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Total Tasks</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalTasks }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Completed Tasks</div>
            <div class="card-body">
                <h5 class="card-title">{{ $completedTasks }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">In Progress Tasks</div>
            <div class="card-body">
                <h5 class="card-title">{{ $inProgressTasks }}</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Pending Tasks</div>
            <div class="card-body">
                <h5 class="card-title">{{ $pendingTasks }}</h5>
            </div>
        </div>
    </div>
</div>

<h2>Daily Statistics</h2>
<p>Total Tasks: {{ $daily['total_tasks'] }}</p>
<p>Completed Tasks: {{ $daily['completed_tasks'] }}</p>
<p>Completion Rate: {{ $daily['completion_rate'] }}%</p>
<p>Average Completion Time: {{ $daily['average_completion_time'] }} hours</p>

<h2>Weekly Statistics</h2>
<p>Total Tasks: {{ $weekly['total_tasks'] }}</p>
<p>Completed Tasks: {{ $weekly['completed_tasks'] }}</p>
<p>Completion Rate: {{ $weekly['completion_rate'] }}%</p>
<p>Average Completion Time: {{ $weekly['average_completion_time'] }} hours</p>

<h2>Monthly Statistics</h2>
<p>Total Tasks: {{ $monthly['total_tasks'] }}</p>
<p>Completed Tasks: {{ $monthly['completed_tasks'] }}</p>
<p>Completion Rate: {{ $monthly['completion_rate'] }}%</p>
<p>Average Completion Time: {{ $monthly['average_completion_time'] }} hours</p>

@endsection