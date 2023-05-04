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

  
    public function kelompok_mahasiswa()
    {
        return $this->hasMany(KelompokMahasiswa::class);
    }

    public function bimbingan()
    {
        return $this->hasMany(Request::class);
    }

    // public function kelompok(){
    //     return $this->hasMany(Kelompok::class, 'id', 'kelompok_id');
    // }

    public function pembimbing_penguji()
    {
        return $this->hasMany(PembimbingPenguji::class);
    }

    public function pembimbings()
    {
        return $this->hasOne(Pembimbing::class, 'kelompok_id', 'id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    public function pengujis()
    {
        return $this->hasOne(Penguji::class, 'kelompok_id', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing', 'nidn');
    }
    public function Krs(){
        return $this->belongsTo(Krs::class, 'krs_id', 'id');
    }

    public function role_kelompok(){
        return $this->hasMany(RoleKelompok::class, 'kelompok_id', 'id');
    }
}
