<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class KomponenPenilaian extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    // use HasFactory;

    protected $guarded = ['id'];

    public function poin_regulasi(){
        return $this->belongsTo(PoinRegulasi::class, 'poin_regulasi_id','id');
    }

    public function detail_nilai_mahasiswa(){
        return $this->hasMany(DetailNilaiMahasiswa::class, 'komponen_id','id')
                    ->join('nilai_mahasiswas', 'detail_nilai_mahasiswas.nilai_id', 'nilai_mahasiswas.id')
                    ->join('role_kelompoks', 'nilai_mahasiswas.role_dosen_kelompok_id', 'role_kelompoks.id')
                    // ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', 'role_group_kelompoks.id')
                    ->select('nilai_mahasiswas.*', 'detail_nilai_mahasiswas.*','role_kelompoks.*');
    }
    
    // public function detail_nilai_mahasiswa(){
    //     return $this->hasMany(DetailNilaiMahasiswa::class, 'komponen_id','id')
    //                 ->join('nilai_mahasiswas', 'detail_nilai_mahasiswas.nilai_id', 'nilai_mahasiswas.id')
    //                 ->select('nilai_mahasiswas.*', 'detail_nilai_mahasiswas.*');
    // }

}
