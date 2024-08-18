<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DailyTaskStatistics extends Notification
{
    use Queueable;

    private $statistics;

    public function __construct($statistics)
    {
        $this->statistics = $statistics;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Daily Task Statistics')
            ->view('emails.task_statistics', ['statistics' => $this->statistics]);
    }
}
