<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProjectTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($project_id = 1; $project_id <= 10; $project_id++) {
            $weekIds = range(1, 14);
            $teamMembers = DB::table('project_teams')->where('project_id', $project_id)->pluck('student_id')->toArray();

            foreach ($weekIds as $week_id) {
                $numTasks = rand(1, 3); // عدد المهام في الأسبوع
                shuffle($teamMembers);
                $assignedStudents = array_slice($teamMembers, 0, $numTasks);

                foreach ($assignedStudents as $student_id) {
                    DB::table('project_tasks')->insert([
                        'project_id' => $project_id,
                        'week_id' => $week_id,
                        'student_id' => $student_id,
                        'title' => "Task Week $week_id for Student $student_id",
                        'description' => "Description of Task Week $week_id",
                        'status' => 'to_do',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

