<?php

namespace Database\Factories;

use App\Models\RoleList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoleList>
 */
class RoleListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'staff_id' => $this->faker->numberBetween(1, 50),
            'role_id' => $this->faker->numberBetween(1, 10),
        ];
        
        $existingRoleList = RoleList::where($data)->first();
        if ($existingRoleList) {
            return $this->definition();
        } else {
            return $data;
        }
    }
}
