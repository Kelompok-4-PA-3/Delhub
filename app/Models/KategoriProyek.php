<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class KategoriProyek extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    // public function krs(){
    //     return $this->hasMany(Krs::class);
    // }

    public function poin_regulasi(){
       return $this->hasMany(PoinRegulasi::class, 'kategori_id', 'id');
    }
}
