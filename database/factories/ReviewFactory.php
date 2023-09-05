<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            'customer_id' => $faker->numberBetween(1, 50),
            'rate' => $faker->numberBetween(1, 5),
            'title' => $faker->sentence,
            'description' => $faker->paragraph(3,true),
        ];
    }
}
