<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Machine;
use App\Models\Status;
use App\Models\Branch;
use App\Models\AccountType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'idacctype' => 1,
                'name' => 'System Admin',
                'email' => 'sysadmin@d.com',
                'password' => bcrypt('1234'),
            ],
            [
                'id' => 2,
                'idacctype' => 2,
                'name' => 'Helpdesk One',
                'email' => 'helpdesk@d.com',
                'password' => bcrypt('1234'),
            ],
            [
                'id' => 3,
                'idacctype' => 3,
                'idstat' => 2,
                'name' => 'The Technician',
                'email' => 'fieldtechk@d.com',
                'password' => bcrypt('1234'),
            ],
        ];

        // Create users
        foreach ($users as $user) {
            User::factory()->create($user);
        }

        // Seed other models
        Status::factory(27)->create();
        Ticket::factory(5)->create();
        Machine::factory(100)->create();
        Branch::factory(5)->create();
        AccountType::factory(5)->create();
    }
}
