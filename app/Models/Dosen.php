<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Spatie\Permission\Traits\HasRoles;

class Dosen extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;
    use HasRoles;

    protected $primarykey = ['nidn'];

    protected $fillable = ['nidn', 'user_id', 'prodi_id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function krs()
    {
        return $this->hasMany(Krs::class, 'dosen_mk', 'nidn');
    }

    public function krs2()
    {
        return $this->hasMany(Krs::class, 'dosen_mk_2', 'nidn');
    }

    // public function krs(){
    //     return $this->hasMany(Krs::class, 'dosen_mk', 'nidn');
    // }

    public function kelompok()
    {
        return $this->hasMany(Kelompok::class, 'pembimbing', 'nidn');
    }

    public function pembimbing_1()
    {
        return $this->hasMany(Pembimbing::class, 'pembimbing_1', 'nidn');
    }

    public function pembimbing_2()
    {
        return $this->hasMany(Pembimbing::class, 'pembimbing_2', 'nidn');
    }

    public function role_kelompok()
    {
        return $this->hasMany(RoleKelompok::class, 'nidn', 'nidn');
    }

    public function role_kelompok_group()
    {
        return $this->hasMany(RoleKelompok::class, 'nidn', 'nidn')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id');
    }

    public function all_role_kelompok()
    {
        return $this->hasMany(RoleKelompok::class, 'nidn', 'nidn')
            ->join('kelompoks', 'role_kelompoks.kelompok_id', 'kelompoks.id')
            ->join('krs', 'kelompoks.krs_id', 'krs.id')
            ->where('krs.deleted_at', NULL);
    }

    public function getRouteKeyName()
    {
        return 'nidn';
    }
}
