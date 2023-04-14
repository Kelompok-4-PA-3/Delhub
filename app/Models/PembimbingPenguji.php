<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PembimbingPenguji extends Model
{
    use HasFactory;
    // use SoftDeletes;
    // use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'dosen_id', 'nidn');
    }
    
    public function reference(){
        return $this->belongsTo(Reference::class, 'reference_id', 'id');
    }

    // public function reference(){
    //     $this->belongsToMany(Reference::class, 'reference_id');
    // }
    
    public function kelompok(){
        return $this->belongsToMany(Kelompok::class, 'kelompok_id', 'id');
    }

    public function pembimbing(){
        return $this->belongsToMany(Reference::class)->where('kategori', '=', 'kelompok')->where('value', '=', 'pembimbing');
    }

}
