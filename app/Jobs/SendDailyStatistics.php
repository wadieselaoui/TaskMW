<?php

namespace App\Jobs;

use App\Notifications\DailyTaskStatistics;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDailyStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $statistics = $this->getStatistics($user, 'day');
            $user->notify(new DailyTaskStatistics($statistics));
        }
    }

    private function getStatistics($user, $period)
    {
        $endDate = now();
        $startDate = $endDate->copy()->startOf($period);

        $tasks = $user->tasks()->whereBetween('created_at', [$startDate, $endDate])->get();

        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        $averageCompletionTime = $tasks->where('status', 'completed')
            ->avg(fn($task) => $task->updated_at->diffInHours($task->created_at));

        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'completion_rate' => round($completionRate, 2),
            'average_completion_time' => round($averageCompletionTime, 2),
        ];
    }
}
