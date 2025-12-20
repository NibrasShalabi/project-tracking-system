<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProjectWeeksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($project_id = 1; $project_id <= 10; $project_id++) {
            for ($week = 1; $week <= 14; $week++) {
                DB::table('project_weeks')->insert([
                    'project_id' => $project_id,
                    'week_number' => $week,
                    'sprint_title' => "Sprint $week",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

