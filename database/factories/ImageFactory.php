<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $width = $faker->numberBetween(800, 1200);
        $height = $faker->numberBetween(600, 900);
        $imageUrl = "https://picsum.photos/{$width}/{$height}";
        return [
            'url' => $imageUrl,
        ];
    }
}
