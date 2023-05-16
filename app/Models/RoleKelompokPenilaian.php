<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RoleKelompokPenilaian extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    public function role_kelompok(){
        return $this->belongsTo(RoleKelompok::class, 'role_kelompok_id', 'id');
    }

    public function nilai_mahasiswa_role($nim, $role){
        return $this->hasMany(DetailNilaiMahasiswaRole::class, 'komponen_role_penilaian_id', 'id')
                                                        ->join('nilai_mahasiswa_roles', 'detail_nilai_mahasiswa_roles.nilai_role_id', 'nilai_mahasiswa_roles.id')
                                                        ->where('nilai_mahasiswa_roles.nim',$nim)
                                                        ->where('nilai_mahasiswa_roles.role_kelompok_id',$role)
                                                        ->select('detail_nilai_mahasiswa_roles.*',
                                                                 'nilai_mahasiswa_roles.kelompok_id',
                                                                 'nilai_mahasiswa_roles.role_kelompok_id',);
    }
}
