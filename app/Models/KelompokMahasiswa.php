<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class KelompokMahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $fillable = ['kelompok_id', 'nim', 'role'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function reference()
    {
        return $this->belongsTo(Reference::class, 'role', 'id');
    }
}
