<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;


class Pembimbing extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $fillable = ['user_id','pembimbing1','pembimbing2'];

    public function kelompok(){
        return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
    }

    public function pembimbing_1_dosen(){
        return $this->belongsTo(Dosen::class, 'pembimbing_1', 'nidn');
    }

    public function pembimbing_2_dosen(){
        return $this->belongsTo(Dosen::class, 'pembimbing_2', 'nidn');
    }
} 
