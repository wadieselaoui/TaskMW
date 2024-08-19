# Todo App

This is a Laravel Todo application with task management, email notifications, and statistics.

## Requirements

-   Docker
-   Docker Compose

## Setup

1. Clone the repository
2. Run `docker-compose up -d --build`
3. Run `docker-compose exec app php artisan migrate`
4. Access the application at `http://localhost`
5. Access the emails at `http://localhost:8025`

## Features

-   Task management (CRUD operations)
-   Email notifications for task reminders, assignments, and modifications
-   Daily/Weekly/Monthly statistics
-   Logging of significant events
-   Authentication and Authorization




