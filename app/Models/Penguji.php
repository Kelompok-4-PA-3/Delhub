<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;


class Penguji extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $fillable = ['user_id','penguji1','penguji2'];

    public function kelompok(){
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

    public function penguji_1_dosen(){
        return $this->belongsTo(Dosen::class, 'penguji_1', 'nidn');
    }

    public function penguji_2_dosen(){
        return $this->belongsTo(Dosen::class, 'penguji_2', 'nidn');
    }
}
