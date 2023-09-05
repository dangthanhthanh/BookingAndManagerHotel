<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
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
            'name' => $faker->sentence,
            'image_id' => Image::factory(),
            'category_id' => $faker->numberBetween(1, 5), // Assuming you have 5 categories
            'short_description' => $faker->paragraph,
            'description' => $faker->paragraphs(3, true),
        ];
    }
}
