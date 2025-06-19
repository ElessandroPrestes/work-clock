<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_US');
        return [
            'name'              => $this->faker->name(),
            'cpf'               => $this->faker->unique()->numerify('###########'),
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => bcrypt('password'),
            'role'              => $this->faker->randomElement(['admin', 'manager', 'employee']),
            'position'          => $this->faker->randomElement(['Analista', 'Desenvolvedor', 'Gerente']),
            'birthdate'         => $this->faker->date('Y-m-d', now()->subYears(20)->toDateString()),
            'manager_id'        => null,
            'remember_token'    => \Illuminate\Support\Str::random(10),
        ];
    }
}
