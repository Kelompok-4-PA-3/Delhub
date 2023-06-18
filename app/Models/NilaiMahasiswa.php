<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class NilaiMahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function role_kelompok(){
        return $this->belongsTo(RoleKelompok::class, 'role_dosen_kelompok_id', 'id');
    }

    public function poin_penilaian(){
        return $this->belongsTo(PoinPenilaian::class, 'poin_penilaian_id', 'id');
    }

    public function detail_nilai_mahasiswa(){
        return $this->hasMany(DetailNilaiMahasiswa::class, 'nilai_id', 'id');
    }

    public function role_group_penilaian(){
        return $this->hasMany(RoleGroupPenilaian::class, 'poin_penilaian_id', 'id');
    }

    public function kelompok(){
        return $this->belongsTo(Kelompok::class);
    }

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
