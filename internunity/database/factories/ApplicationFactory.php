<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = [ "applied", "interviewing", "rejected", "selected" ];
        return [
            "internship_id" => fake()->numberBetween(1, 50),
            "status" => fake()->randomElement($status),
            "user_id" => fake()->numberBetween(1, 50)
        ];
    }
}
