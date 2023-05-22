<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class KategoriRole extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    public function role_group()
    {
        return $this->hasMany(RoleGroupKelompok::class, 'kategori_id', 'id');
    }

    public function krs(){
        return $this->belongsTo(Krs::class, 'krs_id', 'id');
    }
}
