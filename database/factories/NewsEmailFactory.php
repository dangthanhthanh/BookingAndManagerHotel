<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsEmail>
 */
class NewsEmailFactory extends Factory
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
            'email' => $faker->unique()->safeEmail,
            'email_verified_token' => $faker->optional()->md5,
            'email_verified_at' => $faker->optional()->dateTimeThisYear,
        ];
    }
}
