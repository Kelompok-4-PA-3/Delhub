<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RoleKelompok extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $guarded = ['id'];

    public function dosen(){
        return $this->hasOne(Dosen::class, 'nidn', 'nidn');
    }

}
