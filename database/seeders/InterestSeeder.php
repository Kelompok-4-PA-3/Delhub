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
            'nama' => 'Programmer',
            'keterangan' => 'programmer',
        ]);

        \App\Models\Interest::create([
            'nama' => 'Designer',
            'keterangan' => 'designer',
        ]);

        \App\Models\Interest::create([
            'nama' => 'Technical Writer',
            'keterangan' => 'technical writer',
        ]);

        \App\Models\Interest::create([
            'nama' => 'Tester',
            'keterangan' => 'tester',
        ]);

        \App\Models\Interest::create([
            'nama' => 'System Analyst',
            'keterangan' => 'system analyst',
        ]);
    }
}
