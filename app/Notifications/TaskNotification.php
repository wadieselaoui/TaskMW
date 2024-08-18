<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $action;

    public function __construct(Task $task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your task has been ' . $this->action . '.')
            ->line('Title: ' . $this->task->title)
            ->line('Description: ' . $this->task->description)
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Thank you for using our application!');
    }
}