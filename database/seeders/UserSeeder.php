<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::factory()->create([
            'name' => 'Admin Master',
            'cpf' => '12345678900',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'cargo' => 'Administrador',
            'data_nascimento' => '1990-01-01',
            'cep' => '12345-678',
            'gestor_id' => null, 
        ]);

        User::factory(10)->create();
    }
}
