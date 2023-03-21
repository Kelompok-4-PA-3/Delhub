<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\ModelHasRoles;
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

        Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'dosen',
            'guard_name' => 'web'
        ]);

        ModelHasPermission::create([
            'role_id' => 1,
            'model_type' => 'App\Models\User', // Change this to the model you want to assign the permission to
            'model_id' => 12, // Change this to the ID of the model you want to assign the permission to
        ]);

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

        \App\Models\Roles::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web',
        ]);

        \App\Models\Roles::create([
            'name' => 'dosen',
            'guard_name' => 'web',
        ]);

        \App\Models\Permission::create([
            'name' => 'kelola kelompok',
            'guard_name' => 'web',
        ]);

        \App\Models\Permission::create([
            'name' => 'kelola bimbingan',
            'guard_name' => 'web',
        ]);

        \App\Models\Ruangan::create([
            'nama' => 'Gedung Vokasi',
        ]);

        \App\Models\Mahasiswa::create([
            'nim' => '11420033',
            'user_id' => 2,
            'prodi_id' => 1,
            'angkatan' => '2002',
        ]);

        \App\Models\Dosen::create([
            'nidn' => '12312039812',
            'user_id' => 2,
            'prodi_id' => 1,
        ]);

        // \App\Models\::create([
        //     'name' => 'kelola bimbingan',
        //     'guard_name' => 'web',
        // ]);
    }
}
