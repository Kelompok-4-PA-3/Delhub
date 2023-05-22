<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RoleGroupKelompok extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    // public function role_kelompok(){
    //     return $this->hasOne(RoleKelompok::class, 'role_group_id', 'id');
    // }

    public function komponen_penilaian_role()
    {
        return $this->belongsTo(RoleKelompokPenilaian::class, 'role_group_id', 'id');
    }

    public function komponen_penilaian()
    {
        return $this->hasMany(RoleKelompokPenilaian::class, 'role_group_id', 'id');
    }

    public function role_group_penilaian()
    {
        return $this->hasMany(RoleGroupPenilaian::class, 'role_group_id', 'id');
    }

    public function role_kategori()
    {
        return $this->belongsTo(KategoriRole::class, 'kategori_id', 'id');
    }

    public function role_group_penilaian_bobot()
    {
        return $this->hasMany(RoleGroupPenilaian::class, 'role_group_id', 'id')
            ->join('poin_penilaians', 'role_group_penilaians.poin_penilaian_id', 'poin_penilaians.id')
            ->select('role_group_penilaians.*', 'poin_penilaians.*');
    }

    // public function role_group_penilaian(){
    //     return $this->hasMany(RoleGroupPenilaian::class, 'role_group_id', 'id');
    // }
}
