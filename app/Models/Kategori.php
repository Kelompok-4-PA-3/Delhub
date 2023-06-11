<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function kategori()
    {
        return $this->belongsTo(KategoriProyek::class, 'kategori_proyek', 'id')->withTrashed();
    }
}
