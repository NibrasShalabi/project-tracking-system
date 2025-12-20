<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('projects')->insert([
                'title' => "IT Graduation Project $i",
                'description' => "Description of IT Project $i",
                'field' => "Information Systems",
                'type' => 'graduation',
                'status' => 'in_progress',
                'college_id' => 1,
                'semester_id' => rand(1, 3),
                'coordinator_id' => 1, 
                'cover_image' => null,
                'start_date' => now()->subDays(14 * $i),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
