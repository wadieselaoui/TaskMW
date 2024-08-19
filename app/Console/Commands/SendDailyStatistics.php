<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\StatisticsController;

class SendDailyStatistics extends Command
{
    protected $signature = 'email:daily-statistics';
    protected $description = 'Send daily task statistics to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $statisticsController = new StatisticsController();
        $statisticsController->sendDailyNotifications();
        $this->info('Daily statistics emails have been sent.');
    }
}


