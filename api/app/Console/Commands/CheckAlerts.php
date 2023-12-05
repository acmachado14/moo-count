<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AlertConfigurationController;

class CheckAlerts extends Command
{
    protected $signature = 'check:alerts';
    protected $description = 'Check daily alerts and send notifications';

    public function handle()
    {
        $controller = new AlertConfigurationController();
        $controller->checkDailyAlerts();

        $this->info('Alerts checked successfully.');
    }
}
