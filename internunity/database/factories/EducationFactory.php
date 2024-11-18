<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = [ "matric", "intermediate", "bachelors", "masters", "Ph.D"];
        $type = [1, 2, 3];
        return [
            "education" => fake()->randomElement($levels),
            "organization" => fake()->company(),
            "from" => now(),
            "to" => now(),
            "grade" => fake()->numberBetween(50, 100),
            "type" => fake()->randomElement($type),
            "description" => fake()->text(),
            "user_id" => fake()->numberBetween(1, 50)
        ];
    }
}
