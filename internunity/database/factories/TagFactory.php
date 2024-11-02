<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            'PHP', 'JavaScript', 'Python', 'Java', 'C++', 'HTML', 'CSS', 'Laravel', 'React', 'Vue.js',
            'Node.js', 'SQL', 'Git', 'Machine Learning', 'Docker', 'AWS', 'TypeScript', 'Ruby', 'Kotlin', 'Swift',
            'Angular', 'Bootstrap', 'jQuery', 'Sass', 'GraphQL', 'MongoDB', 'Redis', 'Firebase', 'MySQL', 'PostgreSQL',
            'Tailwind CSS', 'Express.js', 'TensorFlow', 'PyTorch', 'Flask', 'Django', 'Kubernetes', 'Terraform', 'Apache',
            'Nginx', 'WordPress', 'Shopify', 'Jenkins', 'Spring Boot', 'MATLAB', 'R', 'Go', 'Scala', 'Rust', 'Elasticsearch'
        ];
        return [
            "tag" => fake()->unique()->randomElement($skills),
            "status" => fake()->boolean()
        ];
    }
}
