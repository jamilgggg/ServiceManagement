<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->numberBetween(1, 10),
            'priority' => fake()->numberBetween(1, 3),
            'ticket_number' => fake()->unique()->bothify('MAN-HD-#######'),
            'type' => 1,
            'work_done' => fake()->numberBetween(1, 10),
            'reported_by' => fake()->numberBetween(1, 10),
            'acknowledged_by' => fake()->numberBetween(1, 20),
            'acknowledgedby_datetime' => fake()->dateTimeBetween('-1 year', 'now'),
            'technician_by' => fake()->numberBetween(1, 20),
            'client_contactnum' => fake()->phoneNumber,
            'client_email' => fake()->safeEmail,
            'fk_mif' => fake()->numberBetween(1, 20),
        ];
    }
}
