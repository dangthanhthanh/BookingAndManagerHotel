<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingFood>
 */
class BookingFoodFactory extends Factory
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
            'food_id' => $faker->numberBetween(1, 10), // Assuming you have 50 food items
            'check_in' => $faker->dateTimeThisMonth(),
            'cost' => $faker->numberBetween(50000, 500000),
            'qty' => $faker->numberBetween(1, 5),
            'note' => $faker->paragraph,
        ];
    }
}
