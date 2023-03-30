<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Kelompok extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function kelompok_mahasiswa(){
        return $this->hasMany(KelompokMahasiswa::class);
    }

    public function bimbingan(){
        return $this->hasMany(Request::class);
}

    public function pembimbing_penguji(){
        return $this->hasMany(PembimbingPenguji::class);
    }

    public function dosen(){
        return $this->belongsTo(Dosen::class,'pembimbing','nidn');
    }
}
