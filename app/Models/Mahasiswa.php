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

    public function krs_user(){
        return $this->hasMany(KrsUser::class, 'user_id', 'user_id');
    }

    public function kelompok_mahasiswa(){
        return $this->hasMany(KelompokMahasiswa::class, 'nim', 'nim');
    }

    public function getRouteKeyName()
    {
        return 'nim';
    }

<<<<<<< HEAD
    public function jadwal(){
        return $this->belongsTo(Jadwal::class);
=======
    public function kelompokMahasiswa(){
        return $this->hasMany(KelompokMahasiswa::class);
>>>>>>> 795a7e58360873a933373d7cad4bbdfb23b0fbf7
    }
}
