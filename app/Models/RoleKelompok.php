<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RoleKelompok extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    public function dosen(){
        return $this->hasOne(Dosen::class, 'nidn', 'nidn');
    }

    public function role_group(){
        return $this->belongsTo(RoleGroupKelompok::class, 'role_group_id', 'id');
    }

    public function role_group_penilaian(){
        return $this->belongsTo(RoleKelompokPenilaian::class, 'role_group_id', 'id');
    }

    public function kelompok(){
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

}
