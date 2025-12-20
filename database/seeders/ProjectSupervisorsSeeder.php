<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProjectSupervisorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($project_id = 1; $project_id <= 10; $project_id++) {
            DB::table('project_supervisors')->insert([
                'project_id' => $project_id,
                'supervisor_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

