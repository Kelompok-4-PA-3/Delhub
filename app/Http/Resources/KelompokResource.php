<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelompokResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->nama_kelompok,
            'topik' => $this->topik ? $this->topik->nama : "Belum ada topik",
            'pembimbing' => $this->pembimbings->pembimbing_1_dosen->user->nama,
        ];
    }
}
