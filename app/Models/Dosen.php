<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Dosen extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $primarykey = ['nidn'];

    protected $fillable = ['nidn','user_id','prodi_id'];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }

    public function kelompok(){
        return $this->hasMany(Kelompok::class ,'pembimbing', 'nidn');
    }

    public function pembimbing_penguji(){
        return $this->hasMany(PembimbingPenguji::class);
    }

    public function getRouteKeyName()
    {
        return 'nidn';
    }
}
