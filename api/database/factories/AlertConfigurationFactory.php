<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AlertConfiguration;

class AlertConfigurationFactory extends Factory
{
    protected $model = AlertConfiguration::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'frequency' => $this->faker->randomElement(['daily', 'weekly', 'monthly']),
            'quantity_cattle' => $this->faker->numberBetween(5, 20),
        ];
    }
}
