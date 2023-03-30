<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class KrsUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'user_id', 'user_id');
    }

    public function krs(){
        return $this->belongsTo(Krs::class);
    }

}
