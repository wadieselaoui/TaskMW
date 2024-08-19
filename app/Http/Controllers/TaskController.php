<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\TaskNotification;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Log::info('User ' . Auth::id() . ' accessed the task index page.');

        $tasks = Auth::user()->tasks()->orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        Log::info('User ' . Auth::id() . ' accessed the create task page.');

        return view('tasks.create');
    }

    public function store(Request $request)
    {
        Log::info('User ' . Auth::id() . ' is creating a new task.');

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = 'pending';
        $task->user_id = Auth::id();
        $task->start_date = now();
        $task->save();

        Log::info('Task created successfully: ', $task->toArray());
        $this->sendTaskNotification($task, 'created');

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        Log::info('User ' . Auth::id() . ' accessed the task edit page for task ID: ' . $task->id);

        $this->authorize('update', $task);
        return view('tasks.edit', compact('task'));
    }

    public function show(Task $task)
    {
        Log::info('User ' . Auth::id() . ' accessed the task details page for task ID: ' . $task->id);

        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        Log::info('User ' . Auth::id() . ' is updating task ID: ' . $task->id);

        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($request->all());

        Log::info('Task updated successfully: ', $task->toArray());
        $this->sendTaskNotification($task, 'updated');

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        Log::info('User ' . Auth::id() . ' is deleting task ID: ' . $task->id);

        $this->authorize('delete', $task);
        $task->delete();
        Log::info('Task deleted successfully: ', $task->toArray());

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function markAsCompleted(Request $request, Task $task)
    {
        Log::info('User ' . Auth::id() . ' is marking task ID: ' . $task->id . ' as completed.');

        $task->status = 'completed';
        $task->end_date = now();
        $task->save();

        Log::info('Task marked as completed: ', $task->toArray());

        $this->sendTaskNotification($task, 'completed');

        return redirect()->route('tasks.index')->with('success', 'Task marked as completed.');
    }

    private function sendTaskNotification(Task $task, $action)
    {
        if ($task->user) {
            Log::info('Sending notification for task ID: ' . $task->id . ' with action: ' . $action);
            $task->user->notify(new TaskNotification($task, $action));
        } else {
            Log::warning("Task ID {$task->id} has no associated user.");
        }
    }
}
