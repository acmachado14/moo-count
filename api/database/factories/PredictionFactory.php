<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prediction;

class PredictionFactory extends Factory
{
    protected $model = Prediction::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'quantity' => $this->faker->numberBetween(1, 30),
            'local' => $this->faker->city,
        ];
    }
}
