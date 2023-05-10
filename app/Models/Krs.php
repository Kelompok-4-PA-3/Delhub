<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Krs extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'mk_id');
    }

    public function config(){
        return $this->belongsTo(Configs::class, 'config_id');
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_mk', 'nidn');
    }

    public function dosen2(){
        return $this->belongsTo(Dosen::class, 'dosen_mk_2', 'nidn');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function kelompok(){
        return $this->hasMany(Kelompok::class, 'krs_id', 'id');
    }

    public function krs_user(){
        return $this->hasMany(KrsUser::class);
    }

    public function krs_role(){
        return $this->hasMany(RoleGroupKelompok::class, 'krs_id', 'id');
    }

}
