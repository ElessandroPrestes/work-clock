<?php

namespace Database\Factories;

use App\Models\ClockRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClockRecordFactory extends Factory
{
    protected $model = ClockRecord::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'recorded_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
