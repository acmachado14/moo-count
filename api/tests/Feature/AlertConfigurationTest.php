<?php

namespace Tests\Feature;

use App\Mail\DailyAlertNotification;
use App\Models\AlertConfiguration;
use App\Models\Prediction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AlertConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function testDailyAlertNotificationIsSent()
    {
        $user = User::factory()->create();

        $alert = AlertConfiguration::factory()->create([
            'user_id' => $user->id,
            'frequency' => 'daily',
            'quantity_cattle' => 10,
        ]);

        $this->actingAs($user);

        Prediction::factory()->create([
            'user_id' => $user->id,
            'quantity' => $alert->quantity_cattle - 1,
            'created_at' => Carbon::now(),
        ]);

        Mail::fake();

        $this->artisan('check:alerts');

        Mail::assertSent(DailyAlertNotification::class, function ($mail) use ($user, $alert) {
            return $mail->hasTo($user->email) &&
                $mail->alert->id === $alert->id;
        });
    }

    public function testDailyAlertNotificationIsNotSent()
    {
        $user = User::factory()->create();

        $alert = AlertConfiguration::factory()->create([
            'user_id' => $user->id,
            'frequency' => 'daily',
            'quantity_cattle' => 10,
        ]);

        $this->actingAs($user);

        Prediction::factory()->create([
            'user_id' => $user->id,
            'quantity' => $alert->quantity_cattle + 1,
            'created_at' => Carbon::now(),
        ]);

        Mail::fake();

        $this->artisan('check:alerts');

        Mail::assertNotSent(DailyAlertNotification::class, function ($mail) use ($user, $alert) {
            return $mail->hasTo($user->email) &&
                $mail->alert->id === $alert->id;
        });
    }
}
