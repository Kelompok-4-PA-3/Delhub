<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Krs extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'mk_id');
    }

    public function config()
    {
        return $this->belongsTo(Configs::class, 'config_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_mk', 'nidn');
    }

    public function dosen2()
    {
        return $this->belongsTo(Dosen::class, 'dosen_mk_2', 'nidn');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function kelompok()
    {
        return $this->hasMany(Kelompok::class, 'krs_id', 'id');
    }

    public function kelompok_mahasiswas()
    {
        return $this->hasMany(Kelompok::class, 'krs_id', 'id')
            ->join('kelompok_mahasiswas', 'kelompoks.id', 'kelompok_mahasiswas.kelompok_id')
            ->select('kelompoks.nama_kelompok', 'kelompoks.id', 'kelompok_mahasiswas.*');
    }

    public function krs_user()
    {
        return $this->hasMany(KrsUser::class);
    }

    public function kategori_role()
    {
        return $this->hasMany(KategoriRole::class, 'krs_id', 'id');
    }

    public function kategori_role_get_role()
    {
        return $this->hasMany(KategoriRole::class, 'krs_id', 'id')
            ->join('role_group_kelompoks', 'kategori_roles.id', 'role_group_kelompoks.kategori_id')
            ->where('role_group_kelompoks.deleted_at', NULL)
            ->select('role_group_kelompoks.*');
    }

    public function kategori_role_get_pembimbing()
    {
        return $this->hasMany(KategoriRole::class, 'krs_id', 'id')
            ->where('kategori_roles.nama', strtolower('pembimbing'))
            ->join('role_group_kelompoks', 'kategori_roles.id', 'role_group_kelompoks.kategori_id')
            ->where('role_group_kelompoks.deleted_at', NULL)
            ->select('role_group_kelompoks.*');
    }

    public function poin_penilaian()
    {
        return $this->hasMany(PoinPenilaian::class, 'krs_id', 'id');
    }

    public function template()
    {
        return $this->hasMany(TemplateDocument::class, 'krs_id', 'id');
    }

    public function submission()
    {
        return $this->hasMany(SubmissionArtefak::class, 'krs_id', 'id');
    }
}
