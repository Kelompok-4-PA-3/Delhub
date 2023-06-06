<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KrsResource extends JsonResource
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
            'mataKuliah' => $this->whenLoaded('kategori', function () {
                // return nama mata kuliah
                return $this->kategori->nama_singkat;
            }),
            'dosen' => $this->whenLoaded('dosen', function () {
                // return nama dosen
                return $this->dosen->user->nama;
            }),
        ];
    }
}
