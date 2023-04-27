<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PoinRegulasi extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function kategori_proyek(){
        return $this->belongsTo(KategoriProyek::class, 'kategori_id', 'id');
    }

    public function komponen_penilaian(){
        return $this->hasMany(KomponenPenilaian::class, 'poin_regulasi_id', 'id');
    }
}
