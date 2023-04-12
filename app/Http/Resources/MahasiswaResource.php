<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nim' => $this->nim,
            'angkatan' => $this->angkatan,
            'prodi' => $this->prodi->nama,
            'kelompok' => $this->kelompok_mahasiswa->first()->kelompok->nama_kelompok,
        ];
    }
}
