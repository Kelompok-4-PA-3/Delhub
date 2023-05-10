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
        return $this->hasMany(RoleKelompok::class, 'kelompok_id', 'id')
        ->join('role_group_kelompoks','role_kelompoks.role_group_id','role_group_kelompoks.id')
        ->select('role_kelompoks.*','role_group_kelompoks.bobot','role_group_kelompoks.nama');
    }

    public function nilai_mahasiswa(){
        return $this->hasMany(NilaiMahasiswa::class, 'kelompok_id', 'id');
    }
}
