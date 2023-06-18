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

    public function kelompok_mahasiswas()
    {
        return $this->hasMany(KelompokMahasiswa::class, 'kelompok_id', 'id');
    }

    public function mahasiswas()
    {
        // join table kelompok_mahasiswas
        // get also role in kelompok_mahasiswas
        // get mahasiswa where nim is mahasiswa nim
        return $this->hasManyThrough(Mahasiswa::class, KelompokMahasiswa::class, 'kelompok_id', 'nim', 'id', 'nim')
            ->join('references', 'kelompok_mahasiswas.role', '=', 'references.id')
            ->select('mahasiswas.*', 'references.value as role');
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

    public function Krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id', 'id');
    }

    public function role_kelompok()
    {
        return $this->hasMany(RoleKelompok::class, 'kelompok_id', 'id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id')
            ->select('role_kelompoks.*', 'role_group_kelompoks.nama');
    }

    public function role_kelompok_all()
    {
        return $this->hasMany(RoleKelompok::class, 'kelompok_id', 'id');
    }

    public function role_group()
    {
        return $this->hasManyThrough('App\Models\RoleGroupKelompok', 'App\Models\RoleKelompok', 'kelompok_id', 'id', 'id', 'role_group_id');
    }

    public function pembimbings()
    {
        // get pembimbing where kategori is pembimbing
        // kategori have relation with role_group_kelompok
        // role_group_kelompok have relation with role_kelompok
        return $this->hasManyThrough('App\Models\Dosen', 'App\Models\RoleKelompok', 'kelompok_id', 'nidn', 'id', 'nidn')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing');
        // return $this->hasManyThrough('App\Models\Dosen', 'App\Models\RoleKelompok', 'kelompok_id', 'nidn', 'id', 'nidn');
    }

    public function nilai_mahasiswa()
    {
        return $this->hasMany(NilaiMahasiswa::class, 'kelompok_id', 'id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'kelompok_id', 'id');
    }
}
