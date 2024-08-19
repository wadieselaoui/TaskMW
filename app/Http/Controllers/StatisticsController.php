<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;  // Ensure you include the User model
use App\Notifications\DailyTaskStatistics;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks;

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        $pendingTasks = $tasks->where('status', 'pending')->count();

        $daily = $this->getStatistics($user, 'day');
        $weekly = $this->getStatistics($user, 'week');
        $monthly = $this->getStatistics($user, 'month');

        return view('statistics.index', compact('totalTasks', 'completedTasks', 'inProgressTasks', 'pendingTasks', 'daily', 'weekly', 'monthly'));
    }

    private function getStatistics($user, $period)
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->startOf($period);

        $tasks = $user->tasks()->whereBetween('created_at', [$startDate, $endDate])->get();

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $averageCompletionTime = $tasks->where('status', 'completed')
            ->avg(function ($task) {
                return $task->updated_at->diffInHours($task->created_at);
            });

        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'completion_rate' => round($completionRate, 2),
            'average_completion_time' => round($averageCompletionTime, 2),
        ];
    }

    public function sendDailyNotifications()
    {
        // Fetch all users from the database
        $users = User::all();

        foreach ($users as $user) {
            // Get daily statistics for the current user
            $statistics = $this->getStatistics($user, 'day');

            // Send the notification with the user's statistics
            $user->notify(new DailyTaskStatistics($statistics));
        }
    }
}
