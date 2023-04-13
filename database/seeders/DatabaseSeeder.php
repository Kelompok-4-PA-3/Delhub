<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use UserFactory;
use Hash;
use Str;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::create([
        //     'nama' => 'Rizki Okto S',
        //     'username' => '11420033',
        //     'email' => 'if420033@students.del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        // \App\Models\User::create([
        //     'nama' => 'Agnes Feni R Naibaho',
        //     'username' => '11420030',
        //     'email' => 'if420030@students.del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        // \App\Models\User::create([
        //     'nama' => 'Eladita Nadeak',
        //     'username' => '11420031',
        //     'email' => 'if420031@students.del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        // \App\Models\User::create([
        //     'nama' => 'Riyanthi Sianturi',
        //     'username' => 'riyanthi.sianturi',
        //     'email' => 'riyanthi.sianturi@del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        // \App\Models\User::create([
        //     'nama' => 'Goklas H Panjaitan',
        //     'username' => 'goklas.panjaitan',
        //     'email' => 'goklaspanjaintan@del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        // \App\Models\User::create([
        //     'nama' => 'Ester Yolanda Berutu',
        //     'username' => '11420058',
        //     'email' => 'if420058@students.del.ac.id',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'two_factor_secret' => null,
        //     'two_factor_recovery_codes' => null,
        //     'remember_token' => Str::random(10),
        //     'profile_photo_path' => null,
        //     'current_team_id' => null,
        // ]);

        Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'dosen',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        \App\Models\ModelHasRoles::create([
            'role_id' => 1,
            'model_type' => 'App\Models\User', // Change this to the model you want to assign the permission to
            'model_id' => 12, // Change this to the ID of the model you want to assign the permission to
        ]);

        // for ($i = 0; $i <= 10; $i++) {
        \App\Models\Kategori::create([
            'kode_mk' => '1143201',
            'nama_mk' => 'Proyek Akhir I D4 TRPL',
            'nama_singkat' => 'PA-I-D4-TRPL-2020',
        ]);

        \App\Models\Kategori::create([
            'kode_mk' => '1143202',
            'nama_mk' => 'Proyek Akhir II D4 TRPL',
            'nama_singkat' => 'PA-II-D4-TRPL-2020',
        ]);

        \App\Models\Kategori::create([
            'kode_mk' => '1143203',
            'nama_mk' => 'Proyek Akhir III D4 TRPL',
            'nama_singkat' => 'PA-III-D4-TRPL-2020',
        ]);
        // }

        // \App\Models\Fakultas::create([
        //     'nama' => 'Fakultas Vokasi'
        // ]);

        // \App\Models\Fakultas::create([
        //     'nama' => 'Fakultas Informatika dan Teknik Elektro'
        // ]);

        // \App\Models\Fakultas::create([
        //     'nama' => 'Fakultas Teknologi Industri'
        // ]);

        // \App\Models\Fakultas::create([
        //     'nama' => 'Fakultas Bioteknologi'
        // ]);

        // \App\Models\Prodi::create([
        //     'nama' => 'D4 Teknologi Rekayasa Perangkat Lunak',
        //     'fakultas_id' => 1,
        // ]);

        // \App\Models\Prodi::create([
        //     'nama' => 'D3 Teknologi Informasi',
        //     'fakultas_id' => 1,
        // ]);

        // \App\Models\Prodi::create([
        //     'nama' => 'D3 Teknologi Komputer',
        //     'fakultas_id' => 1,
        // ]);

        \App\Models\Configs::create([
            'tahun_aktif' => '2023',
            'semester' => '5',
        ]);

        \App\Models\Ruangan::create([
            'nama' => 'Gedung Vokasi',
        ]);

        \App\Models\Ruangan::create([
            'nama' => 'Ruangan 724',
        ]);

        \App\Models\Ruangan::create([
            'nama' => 'Ruangan 516',
        ]);

        // \App\Models\Mahasiswa::create([
        //     'nim' => '11420033',
        //     'user_id' => 2,
        //     'prodi_id' => 1,
        //     'angkatan' => '2002',
        // ]);

        // \App\Models\Dosen::create([
        //     'nidn' => '12312039812',
        //     'user_id' => 2,
        //     'prodi_id' => 1,
        // ]);

        \App\Models\Reference::create([
            'value' => 'leader',
            'kategori' => 'role_kelompok',
        ]);

        \App\Models\Reference::create([
            'value' => 'member',
            'kategori' => 'role_kelompok',
        ]);

        \App\Models\Reference::create([
            'value' => 'pembimbing',
            'kategori' => 'role_dosen',
        ]);

        \App\Models\Reference::create([
            'value' => 'penguji',
            'kategori' => 'role_dosen',
        ]);

        \App\Models\Reference::create([
            'value' => 'approved',
            'kategori' => 'status_bimbingan',
        ]);

        \App\Models\Reference::create([
            'value' => 'rejected',
            'kategori' => 'status_bimbingan',
        ]);

        \App\Models\Reference::create([
            'value' => 'reschedule',
            'kategori' => 'status_bimbingan',
        ]);

        \App\Models\Reference::create([
            'value' => 'waiting',
            'kategori' => 'status_bimbingan_default',
        ]);

        \App\Models\KategoriProyek::create([
            'nama' => 'Proyek Akhir',
        ]);

        \App\Models\KategoriProyek::create([
            'nama' => 'Tugas Akhir I',
        ]);
        
        \App\Models\KategoriProyek::create([
            'nama' => 'Tugas Akhir II',
        ]);

        \App\Models\KategoriProyek::create([
            'nama' => 'Kerja Praktek',
        ]);

        \App\Models\PoinRegulasi::create([
            'nama' => 'Seminar',
            'poin' => 5,
            'kategori_id' => 1,
        ]);

        \App\Models\PoinRegulasi::create([
            'nama' => 'Proposal',
            'poin' => 5,
            'kategori_id' => 2,
        ]);

        \App\Models\PoinRegulasi::create([
            'nama' => 'Sidang',
            'poin' => 5,
            'kategori_id' => 2,
        ]);

        \App\Models\PoinRegulasi::create([
            'nama' => 'Prasidang',
            'poin' => 5,
            'kategori_id' => 3,
        ]);

        \App\Models\PoinRegulasi::create([
            'nama' => 'Sidang',
            'poin' => 5,
            'kategori_id' => 3,
        ]);

        Permission::create([
            'name' => 'request bimbingan',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'update status bimbingan',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'kelola pembimbing penguji',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'kelola topik kelompok',
            'guard_name' => 'web',
        ]);
        Permission::create([
            'name' => 'hapus bimbingan',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'koordinator',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'dosen',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // \App\Models\PoinRegulasi::create([
        //     'nama' => 'Sidang',
        //     'poin' => 5,
        //     'kategori_id' => 4,
        // ]);

        // $this->call([
        //     InterestSeeder::class,
        // ]);
        $this->call([
            InterestSeeder::class,
        ]);
        // \App\Models\::create([
        //     'name' => 'kelola bimbingan',
        //     'guard_name' => 'web',
        // ]);
    }
}
