<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "project_pic" => null,
            "title" => fake()->title(),
            "description" => fake()->paragraph(),
            "from" => fake()->date(),
            "to" => fake()->date(),
            "github" => "https://github.com/" . fake()->userName(),
            "youtube" => "https://youtube.com/" . fake()->userName(),
            "user_id" => (User::inRandomOrder()->first())->id
        ];
    }
}
