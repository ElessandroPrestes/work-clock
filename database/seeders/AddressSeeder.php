<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $user = User::factory()->create([
            'name' => 'Tony Stark',
            'email' => 'tony@stark.com',
        ]);

        Address::factory()->create([
            'user_id' => $user->id,
        ]);

        Address::factory(10)->create();
    }
}
