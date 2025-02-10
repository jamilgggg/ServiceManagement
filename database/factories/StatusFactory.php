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
        // Predefined list of status names (retained in order)
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

        // Use an index or loop to iterate over the status names sequentially
        static $index = 0;
        $statusName = $statusNames[$index % count($statusNames)]; // Ensure it loops over the array

        // Randomize the color
        $color = fake()->numberBetween(1, 3);

        // Increment the index for the next call
        $index++;

        return [
            'name' => $statusName,
            'color' => $color,
        ];
    }
}


