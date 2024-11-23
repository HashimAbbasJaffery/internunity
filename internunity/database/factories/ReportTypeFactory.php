<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportType>
 */
class ReportTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            "Offensive",
            "Discrimination",
            "Fraudulent",
            "Inappropriate"
        ];
        return [
            "report" => fake()->randomElement($data),
            "status" => fake()->boolean()
        ];
    }
}
