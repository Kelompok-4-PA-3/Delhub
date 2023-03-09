<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MhsInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'interest_id',
    ];

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
