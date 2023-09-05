<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_id' => Image::factory()->create(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'name' => $this->faker->unique()->word,
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'cost' => $this->faker->numberBetween(50, 500)*1000, 
        ];
    }
}
