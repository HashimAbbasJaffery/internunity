<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Internship;
use App\Models\Project;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();

        Experience::factory(50)->create();
        Company::factory(50)->create();
        Internship::factory(50)->create();
        Tag::factory(50)->create();
        Education::factory(50)->create();

        $existing_combinations = [];
        for($i = 0; $i < 50; $i++) {

            $arrays = fake()->unique()->shuffleArray(range(1, 50));
            if(array_search([$arrays[0], $arrays[1]], $existing_combinations)) break;
            $existing_combinations[] = [$arrays[0], $arrays[1]];

            \DB::table("internship_tags")->insert([
                "tag_id" => $arrays[0],
                "internship_id" => $arrays[1]
            ]);

            \DB::table("liked_internships")->insert([
                "user_id" => $arrays[0],
                "internship_id" => $arrays[1]
            ]);
        }

        Project::factory(50)->create();

        Application::factory(50)->create();

        ReportType::factory(5)->create();

        Report::factory(10)->create();

    }
}
