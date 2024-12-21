<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined list of status names
        $statusNames = [
            'OPEN',
            'FOR PARTS REPLACEMENT',
            'FOR QUOTATION',
            'FOR TONER REPAIR',
            'FOR TONER REPLACEMENT',
            'OPEN SERVICE',
            'OPEN DELIVERY',
            'CLOSE SERVICE',
            'CLOSE COLLECTION',
            'FOR COLLECTION',
            'CANCEL',
            'FOR PRINTER REPLACEMENT',
            'FOR PMS',
            'SERVICE DONE',
            'REASSIGNED',
            'FOR INSTALLATION OF PARTS',
            'PULL-OUT FOR REPAIR',
            'PULL-OUT FOR RETURN',
            'FOR PRINTER UPGRADE',
            'FOR INSTALLATION',
            'QUOTATION SENT',
            'WAITING FOR AOS',
            'ON-GOING REPAIR',
            'FOR DEMO',
            'FOR TONER REPLENISHMENT',
            'FOR METER READING',
            'METER READING DONE'
        ];

        $statusName = fake()->randomElement($statusNames);
        $color = fake()->numberBetween(1, 3);

        return [
            'name' => $statusName,
            'color' => $color,
        ];
    }
}
