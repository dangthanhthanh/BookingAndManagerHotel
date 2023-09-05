<?php

namespace Database\Factories;

use App\Models\RoomCategory;
use App\Models\StatusContact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookingRequest>
 */
class BookingRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => User::inRandomOrder()->first()->id,
            'check_in' => $this->faker->dateTimeThisMonth(),
            'check_out' => $this->faker->dateTimeBetween('+1 days', '+7 days'),
            'room_category_id' => RoomCategory::inRandomOrder()->first()->id,
            'num_person' => $this->faker->numberBetween(1, 4),
            'num_child' => $this->faker->numberBetween(0, 2),
            'request' => $this->faker->optional()->text,
            'status_id' => StatusContact::inRandomOrder()->first()->id,
        ];
    }
}
