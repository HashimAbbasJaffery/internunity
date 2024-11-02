<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "company_name" => fake()->company(),
            "from" => fake()->date(),
            "to" => fake()->date(),
            "user_id" => fake()->numberBetween(1, 50),
            "description" => fake()->paragraph()
        ];
    }
}
