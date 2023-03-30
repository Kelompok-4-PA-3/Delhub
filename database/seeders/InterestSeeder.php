<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Interest::create([
            'name' => 'Programmer',
            'slug' => 'programmer',
        ]);

        \App\Models\Interest::create([
            'name' => 'Designer',
            'slug' => 'designer',
        ]);

        \App\Models\Interest::create([
            'name' => 'Technical Writer',
            'slug' => 'technical writer',
        ]);

        \App\Models\Interest::create([
            'name' => 'Tester',
            'slug' => 'tester',
        ]);

        \App\Models\Interest::create([
            'name' => 'System Analyst',
            'slug' => 'system analyst',
        ]);
    }
}
