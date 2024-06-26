<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PoinPenilaian extends Model
{
use HasFactory;
    use SoftDeletes;
    use Userstamps;

    public function komponen_penilaian(){
        return $this->hasMany(KomponenPenilaian::class, 'poin_penilaian_id', 'id');
    }

    public function role_group_penilaian(){
        return $this->hasMany(RoleGroupPenilaian::class, 'poin_penilaian_id', 'id');
    }

    public function nilai_mahasiswa_all(){
        return $this->hasMany(NilaiMahasiswa::class, 'poin_penilaian_id', 'id');
    }

    public function nilai_mahasiswa($nim, $kelompok){
        return $this->hasMany(NilaiMahasiswa::class, 'poin_penilaian_id', 'id')
                                                ->where('nim', $nim)
                                                ->where('kelompok_id', $kelompok)
                                                ->get();
    }

    public function nilai_mahasiswa_kelompok($kelompok){
        return $this->hasMany(NilaiMahasiswa::class, 'poin_penilaian_id', 'id')
                                                ->where('kelompok_id', $kelompok)
                                                ->get();
    }
}
