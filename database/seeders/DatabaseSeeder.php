<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use UserFactory;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        for($i = 0; $i <= 10; $i++){
            \App\Models\Kategori::create([
                'kode_mk' => Str::upper(Str::random(5)),
                'nama_mk' => Str::random(10),
                'nama_singkat' =>  Str::random(3,4),
            ]);
        }

        
        \App\Models\Fakultas::create([
            'nama' => 'Fakultas Vokasi'
        ]);

        \App\Models\Prodi::create([
            'nama' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'fakultas_id' => 1,
        ]);

        \App\Models\Configs::create([
            'tahun_aktif' => '2023',
            'semester' => '5',
        ]);
    }
}
