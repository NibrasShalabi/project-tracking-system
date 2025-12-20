<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Coordinator
        DB::table('project_users')->insert([
            'name' => 'Alice Coordinator',
            'email' => 'coordinator@example.com',
            'password' =>'1234567',
            'role' => 'coordinator',
            'college_id' => 1, // IT
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Supervisor
        DB::table('project_users')->insert([
            'name' => 'Bob Supervisor',
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
            'role' => 'supervisor',
            'college_id' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Students (10)
        for ($i = 1; $i <= 10; $i++) {
            DB::table('project_users')->insert([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'college_id' => 1, // IT
                'student_number' => '2021108' . $i, // Example
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

