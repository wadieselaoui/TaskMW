<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; 
            color: #333; 
        }
        .welcome-container {
            text-align: center;
            padding: 50px;
        }
        .welcome-container h1 {
            color: #007bff; 
        }
        .welcome-container p {
            color: #555; 
        }
    </style>
</head>

<body>
    <div class="welcome-container">
        <h1>Welcome to the Todo App</h1>
        <p>Your task management solution</p>
        @auth
            <a href="{{ route('tasks.index') }}" class="btn btn-primary">Go to Tasks</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
