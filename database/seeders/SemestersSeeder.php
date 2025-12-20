<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SemestersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesters = [
            ['name' => 'First Semester', 'start_date' => '2025-09-01', 'end_date' => '2025-12-31', 'year' => 2025],
            ['name' => 'Second Semester', 'start_date' => '2026-02-01', 'end_date' => '2026-05-31', 'year' => 2026],
            ['name' => 'Summer Semester', 'start_date' => '2026-06-01', 'end_date' => '2026-08-31', 'year' => 2026],
        ];

        foreach ($semesters as $semester) {
            DB::table('semesters')->insert(array_merge($semester, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
