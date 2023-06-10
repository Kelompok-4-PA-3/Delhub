<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Mahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $primarykey = ['nim'];

    protected $fillable = ['nim','user_id','prodi_id','angkatan'];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mhs_interest(){
        return $this->hasMany(MhsInterest::class, 'nim', 'nim');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }

    public function krs_user(){
        return $this->hasMany(KrsUser::class, 'user_id', 'user_id');
    }

    public function kelompok_mahasiswa(){
        return $this->hasMany(KelompokMahasiswa::class, 'nim', 'nim');
    }

    public function getRouteKeyName()
    {
        return 'nim';
    }

    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
    }

    // public function kelompokMahasiswa(){
    //     return $this->hasMany(KelompokMahasiswa::class);
    // }

    public function kelompokMahasiswaKrs(){
        return $this->hasMany(KelompokMahasiswa::class, 'nim', 'nim')
                    ->join('kelompoks','kelompok_mahasiswas.kelompok_id','kelompoks.id')
                    ->join('krs','kelompoks.krs_id','krs.id')
                    ->select('kelompoks.*','krs.*');
    }

    public function nilai_mahasiswa($role, $kelompok, $penilaian){
        return $this->hasMany(NilaiMahasiswa::class, 'nim', 'nim')
                    ->where('role_dosen_kelompok_id', $role)
                    ->where('kelompok_id', $kelompok)
                    ->where('poin_penilaian_id', $penilaian)
                    ->first();
    }

    public function nilai_mahasiswa_role($role, $kelompok){
        return $this->hasMany(NilaiMahasiswaRole::class, 'nim', 'nim')
                    ->where('role_kelompok_id', $role)
                    ->where('kelompok_id', $kelompok)
                    ->first();
    }

        
    public function hasil_nilai_mahasiswa($role, $kelompok){    
        // $roleID = RoleKelompok::find($role);
        return $this->hasMany(NilaiMahasiswa::class, 'nim', 'nim')
                    ->join('role_kelompoks', function($group) use ($role) {
                        $group->on('nilai_mahasiswas.role_dosen_kelompok_id','=','role_kelompoks.id')
                        ->where('role_group_id',$role);
                    })->where('nilai_mahasiswas.kelompok_id', $kelompok)
                    ->get();
    }


    public function total_nilai_mahasiswa($role, $kelompok){
        return $this->hasMany(NilaiMahasiswa::class, 'nim', 'nim')
                    // ->where('role_dosen_kelompok_id', $role)
                    ->where('kelompok_id', $kelompok)
                    ->get();
    }

    public function nilai_all(){
        return $this->hasMany(NilaiMahasiswa::class, 'nim', 'nim');
    }
}
