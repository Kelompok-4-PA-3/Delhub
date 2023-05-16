<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RoleGroupPenilaian extends Model
{
    use HasFactory;
    use softDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    public function role_group(){
        return $this->belongsTo(RoleGroupKelompok::class, 'role_group_id', 'id');
    }

    public function poin_penilaian(){
        return $this->belongsTo(PoinPenilaian::class, 'poin_penilaian_id', 'id');
    }
    
}
