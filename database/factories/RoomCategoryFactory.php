<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomCategory>
 */
class RoomCategoryFactory extends Factory
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
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'cost' => $this->faker->numberBetween(500, 50000)*1000, // Assuming cost is between 100 and 1000
        ];
    }
}
