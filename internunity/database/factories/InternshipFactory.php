<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->jobTitle(),
            "description" => fake()->paragraph(),
            "stipend" => fake()->numberBetween(15000, 20000),
            "status" => fake()->numberBetween(0, 1),
            "company_id" => fake()->numberBetween(1, 50)
        ];
    }
}
