<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CollegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            ['name' => 'Faculty of Informatics', 'abbreviation' => 'IT'],
            ['name' => 'Faculty of Architecture', 'abbreviation' => 'ARCH'],
            ['name' => 'Faculty of Civil Engineering', 'abbreviation' => 'CIV'],
            ['name' => 'Faculty of Medicine', 'abbreviation' => 'MED'],
            ['name' => 'Faculty of Dentistry', 'abbreviation' => 'DENT'],
            ['name' => 'Faculty of Pharmacy', 'abbreviation' => 'PHAR'],
            ['name' => 'Faculty of Business Administration', 'abbreviation' => 'BUS'],
        ];

        foreach ($colleges as $college) {
            DB::table('colleges')->insert(array_merge($college, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
