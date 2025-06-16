<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClockRecord;
use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar 3 gestores (admins)
        $managers = User::factory()->count(3)->create([
            'role' => 'admin',
            'position' => 'Gestor',
        ]);

        // Criar funcionários para cada gestor
        $managers->each(function ($manager) {
            User::factory()
                ->count(3)
                ->state([
                    'role' => 'employee',
                    'position' => 'Funcionário',
                    'manager_id' => $manager->id,
                ])
                ->has(Address::factory())
                ->has(ClockRecord::factory()->count(5), 'timeRecords') 
                ->create();
        });
    }
}
