<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProjectTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($project_id = 1; $project_id <= 10; $project_id++) {
            $numStudents = rand(2, 4);
            $studentIds = range(1, 10);
            shuffle($studentIds);
            $selected = array_slice($studentIds, 0, $numStudents);

            foreach ($selected as $student_id) {
                DB::table('project_teams')->insert([
                    'project_id' => $project_id,
                    'student_id' => $student_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

