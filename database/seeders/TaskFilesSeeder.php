<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TaskFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project_id = 1; 
        $tasks = DB::table('project_tasks')
            ->where('project_id', $project_id)
            ->get();

        foreach ($tasks as $task) {
            $numFiles = rand(1, 2); // 1-2 ملف لكل مهمة
            for ($i = 1; $i <= $numFiles; $i++) {
                DB::table('task_files')->insert([
                    'task_id' => $task->id,
                    'uploaded_by' => $task->student_id,
                    'file_path' => "storage/tasks/project{$project_id}/task{$task->id}_file{$i}.pdf",
                    'file_type' => 'pdf',
                    'uploaded_by_role' => 'student',
                    'uploaded_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

