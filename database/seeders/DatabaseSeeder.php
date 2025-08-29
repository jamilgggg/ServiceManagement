<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Machine;
use App\Models\Status;
use App\Models\Branch;
use App\Models\AccountType;
use App\Models\AccountBranch;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
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
                'email' => 'fieldtech@d.com',
                'password' => bcrypt('1234'),
            ],
        ];

        $usersBranches = [
            [
                'id' => 1,
                'account_id' => 2,
                'branch_id' => 1,
            ],
            [
                'id' => 2,
                'account_id' => 1,
                'branch_id' => 1,
            ],
            [
                'id' => 3,
                'account_id' => 1,
                'branch_id' => 2,
            ],
            [
                'id' => 4,
                'account_id' => 1,
                'branch_id' => 3,
            ],
            [
                'id' => 5,
                'account_id' => 1,
                'branch_id' => 4,
            ],
             [
                'id' => 6,
                'account_id' => 1,
                'branch_id' => 5,
            ],
            [
                'id' => 7,
                'account_id' => 3,
                'branch_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create($user);
        }

        foreach ($usersBranches as $usersBranch) {
            AccountBranch::create($usersBranch);
        }
    
        Status::factory(27)->create();
        Ticket::factory(5)->create();
        Machine::factory(100)->create();
        Branch::factory(5)->create();
        AccountType::factory(5)->create();
    }
}
