<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PredictionsTableSeeder extends Seeder
{
    public function run()
    {
        $userIds = \App\Models\User::pluck('id');

        foreach ($userIds as $userId) {
            $this->createPredictionsForUser($userId);
        }
    }

    private function createPredictionsForUser($userId)
    {
        $startHour = 6;
        $endHour = 18;

        for ($hour = $startHour; $hour <= $endHour; $hour++) {
            $predictions = [
                'user_id' => $userId,
                'quantity' => random_int(1, 10), // Quantidade aleatória para cada hora
                'local' => 'Algum Lugar',
                'created_at' => Carbon::now()->setHour($hour)->setMinute(0)->setSecond(0),
                'updated_at' => Carbon::now()->setHour($hour)->setMinute(0)->setSecond(0),
            ];

            \App\Models\Predictions::create($predictions);
        }
    }
}
