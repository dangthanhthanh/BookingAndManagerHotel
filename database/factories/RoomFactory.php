<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'image_id' => Image::factory()->create(),
            'category_id' => $this->faker->numberBetween(1,10),
            'cost' => $this->faker->numberBetween(50, 500)*1000, 
            'capacity' => $this->faker->numberBetween(1, 4), // Assuming capacity is between 1 and 4
            'bed' => $this->faker->numberBetween(1, 2), // Assuming number of beds is between 1 and 2
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
