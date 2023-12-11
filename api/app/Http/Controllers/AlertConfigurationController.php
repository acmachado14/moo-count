<?php

namespace App\Http\Controllers;

use App\Models\AlertConfiguration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AlertConfigurationController extends Controller
{
    public function checkDailyAlerts()
    {
        // Get all alert configurations for daily frequency
        $dailyAlerts = AlertConfiguration::where('frequency', 'daily')->get();

        foreach ($dailyAlerts as $alert) {
            // Get user predictions for the current day
            $userPredictions = User::find($alert->user_id)->predictions()->whereDate('created_at', now()->toDateString())->get();

            $maxQuantity = $userPredictions->max('quantity');
            if ($maxQuantity < $alert->quantity_cattle) {
                $this->sendEmailNotification($alert, $maxQuantity);
            }
        }
    }

    private function sendEmailNotification($alert, $totalQuantity)
    {
        // Implement the logic to send an email notification
        // You can use Laravel's built-in mail functionality or any other email service

        // Example using Laravel's Mail facade
        Mail::to(User::find($alert->user_id)->email)->send(new \App\Mail\DailyAlertNotification($alert, $totalQuantity));
    }

}
