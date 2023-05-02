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
        return $this->hasMany(DetailNilaiMahasiswa::class, 'komponen_id','id');
    }
}
