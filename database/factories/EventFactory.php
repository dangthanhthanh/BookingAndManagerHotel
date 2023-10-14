<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'name' => $this->faker->unique()->word,
            'cost' => $this->faker->numberBetween(50, 300)*1000, // Assuming cost is between 50 and 300
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
        ];
    }
}
