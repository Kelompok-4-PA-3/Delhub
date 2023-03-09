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
        return $this->belongsTo(User::class);
    }
    
    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }

    public function getRouteKeyName()
    {
        return 'nim';
    }

}
