<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class DetailNilaiMahasiswaRole extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function nilai_role(){
        return $this->belongsTo(NilaiMahasiswaRole::class, 'nilai_role_id', 'id');
    }

    public function komponen_role_penilaian(){
        return $this->belongsTo(RoleKelompokPenilaian::class, 'komponen_role_penilaian_id', 'id');
    }

}
