<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'kel',
        'tanggal',
        'waktu',
        'ruangan',
    ];
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
