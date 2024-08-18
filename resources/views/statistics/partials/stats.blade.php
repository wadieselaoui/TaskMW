<div class="card mb-3">
    <div class="card-body">
        <p>Total Tasks: {{ $stats['total_tasks'] }}</p>
        <p>Completed Tasks: {{ $stats['completed_tasks'] }}</p>
        <p>Completion Rate: {{ $stats['completion_rate'] }}%</p>
        <p>Average Completion Time: {{ $stats['average_completion_time'] }} hours</p>
    </div>
</div>