<?php

namespace Database\Seeders;

use App\Models\ClockRecord;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClockRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Tony Stark',
            'email' => 'stark@stark.com',
        ]);

        ClockRecord::factory(10)->create([
            'user_id' => $user->id,
        ]);
    }
}
