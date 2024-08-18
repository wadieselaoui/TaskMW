<!DOCTYPE html>
<html>
<head>
    <title>Task Statistics</title>
</head>
<body>
    <h1>Daily Task Statistics</h1>
    <p>Total Tasks: {{ $statistics['total_tasks'] }}</p>
    <p>Completed Tasks: {{ $statistics['completed_tasks'] }}</p>
    <p>Completion Rate: {{ $statistics['completion_rate'] }}%</p>
    <p>Average Completion Time: {{ $statistics['average_completion_time'] }} hours</p>
</body>
</html>
