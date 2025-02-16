<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountType>
 */
class AccountTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accTypes = [
            'SYSADMIN' => 'SYS',
            'ADMIN' => 'ADM',
            'FIELD TECHNICIAN' => 'FT',
            'HELPDESK' => 'HD',
            'CLIENT' => 'CL',
        ];

        static $index = 0;
        $accType = array_keys($accTypes)[$index % count($accTypes)];
        $accAlias = $accTypes[$accType];
        $index++;

        return [
            'type' => $accType,
            'alias' => $accAlias,
        ];
    }
}
