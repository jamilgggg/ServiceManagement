<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Machine;
use App\Models\Status;
use App\Models\Branch;
use App\Models\AccountType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('pass123.'),
        ]);
        
        Status::factory(27)->create();
        Ticket::factory(5)->create();
        Machine::factory(5)->create();
        Branch::factory(5)->create();
        AccountType::factory(5)->create();
    }
}
