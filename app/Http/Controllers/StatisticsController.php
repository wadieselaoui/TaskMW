<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\DailyTaskStatistics;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            Log::info("User {$user->id} is accessing the statistics.");

            $tasks = $user->tasks;
            Log::info("User {$user->id} has {$tasks->count()} tasks.");

            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'completed')->count();
            $inProgressTasks = $tasks->where('status', 'in_progress')->count();
            $pendingTasks = $tasks->where('status', 'pending')->count();

            $daily = $this->getStatistics($user, 'day');
            $weekly = $this->getStatistics($user, 'week');
            $monthly = $this->getStatistics($user, 'month');

            return view('statistics.index', compact('totalTasks', 'completedTasks', 'inProgressTasks', 'pendingTasks', 'daily', 'weekly', 'monthly'));
        } catch (\Exception $e) {
            Log::error("An error occurred while generating statistics: " . $e->getMessage());
            return redirect()->back()->withErrors('Unable to load statistics. Please try again later.');
        }
    }

    private function getStatistics($user, $period)
    {
        try {
            $endDate = Carbon::now();
            $startDate = $endDate->copy()->startOf($period);

            Log::info("Calculating {$period} statistics for user {$user->id} from {$startDate} to {$endDate}.");

            $tasks = $user->tasks()->whereBetween('created_at', [$startDate, $endDate])->get();

            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'completed')->count();
            $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            $averageCompletionTime = $tasks->where('status', 'completed')
                ->avg(function ($task) {
                    return $task->updated_at->diffInHours($task->created_at);
                });

            Log::info("User {$user->id} has {$totalTasks} tasks, {$completedTasks} completed, with a completion rate of {$completionRate}%.");

            return [
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'completion_rate' => round($completionRate, 2),
                'average_completion_time' => round($averageCompletionTime, 2),
            ];
        } catch (\Exception $e) {
            Log::error("An error occurred while calculating {$period} statistics for user {$user->id}: " . $e->getMessage());
            return [
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'completion_rate' => 0,
                'average_completion_time' => 0,
            ];
        }
    }

    public function sendDailyNotifications()
    {
        try {
            $users = User::all();
            foreach ($users as $user) {
                $statistics = $this->getStatistics($user, 'day');
                Log::info("Sending daily task statistics to user {$user->id}.");
                $user->notify(new DailyTaskStatistics($statistics));
            }
            Log::info("Daily task statistics notifications have been sent to all users.");
        } catch (\Exception $e) {
            Log::error("An error occurred while sending daily notifications: " . $e->getMessage());
        }
    }
}
