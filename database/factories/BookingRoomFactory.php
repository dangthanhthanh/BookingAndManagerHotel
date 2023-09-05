<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingRoom>
 */
class BookingRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'order_id' => $faker->numberBetween(1, 10), // Assuming you have orders with IDs up to 100
            'room_id' => $faker->numberBetween(1, 10), // Assuming you have 50 rooms
            'room_status_id' => $faker->numberBetween(1, 5), // Assuming you have 5 room statuses
            'check_in' => $faker->dateTimeThisMonth(),
            'check_out' => $faker->dateTimeBetween('+1 days', '+7 days'),
            'number_per' => $faker->numberBetween(1, 4),
            'cost' => $faker->numberBetween(500000, 5000000),
            'cus_request' => $faker->paragraph,
            'note' => $faker->paragraph,
        ];
    }
}
