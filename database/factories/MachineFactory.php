<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial_number' => fake()->unique()->bothify('SN-####-####'),
            'company' => fake()->company,
            'department' => fake()->randomElement(['IT', 'Manufacturing', 'Support', 'Sales', 'HR']),
            'brand' => fake()->randomElement(['Canon', 'HP', 'Ricoh', 'Epson', 'Samsung']),
            'model' => fake()->bothify('Model-####'),
        ];
    }
}
