<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $branchNames = [
            'MANILA',
            'CEBU',
            'DAVAO',
            'ILOILO',
            'BDO',
        ];

        static $index = 0;
        $branchName = $branchNames[$index % count($branchNames)]; // Ensure it loops over the array
        $index++;

        return [
            'branch' => $branchName,
        ];
    }
}
