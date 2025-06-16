<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;

    public function definition(): array
    {
        $role = $this->faker->randomElement(['admin', 'employee']);

        return [
            'name' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), 
            'role' => $role,
            'position' => $role === 'admin' ? 'Gestor' : 'Funcionário',
            'birthdate' => $this->faker->date('Y-m-d', '-20 years'),
            'zip_code' => $this->faker->postcode(),
            'manager_id' => null, 
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
