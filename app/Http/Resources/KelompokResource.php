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
            'topik' => $this->topik ? $this->topik : "Belum ada topik",
            'prodi' => $this->whenLoaded('mahasiswas', function () {
                // get the first mahasiswa
                return $this->mahasiswas->first()->prodi->nama;
            }),
            'angkatan' => $this->whenLoaded('mahasiswas', function () {
                // get the first mahasiswa
                return $this->mahasiswas->first()->angkatan;
            }),
            'pembimbing' => $this->whenLoaded('pembimbings', function () {
                // get the first pembimbing
                return new DosenResource($this->pembimbings->first());
            }),
            'mahasiswa' => $this->whenLoaded('mahasiswas', function () {
                return new MahasiswaCollection($this->mahasiswas);
            }),
            'requests' => $this->whenLoaded('bimbingan', function () {
                return new RequestCollection($this->bimbingan);
            }),

        ];
    }
}
