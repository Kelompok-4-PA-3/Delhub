<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class DetailNilaiMahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected  $guarded  = ['id'];

    public function komponen_nilai(){
        return $this->belongsTo(KomponenPenilaian::class, 'komponen_id', 'id');
    }

    public function nilai_mahasiswa(){
        return $this->belongsTo(NilaiMahasiswa::class, 'nilai_id', 'id');
    }
}
