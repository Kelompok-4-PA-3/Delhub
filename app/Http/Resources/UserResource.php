<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if ($this->hasRole('dosen')) {
            return [
                'id' => $this->id,
                'name' => $this->nama,
                'email' => $this->email,
                'role' => 'dosen',
                'dosen' => $this->whenLoaded('dosen', function () {
                    return new DosenResource($this->dosen);
                }),
            ];
        } else if ($this->hasRole('mahasiswa')) {
            return [
                'id' => $this->id,
                'name' => $this->nama,
                'email' => $this->email,
                'role' => 'mahasiswa',
                'mahasiswa' => $this->whenLoaded('mahasiswa', function () {
                    return new MahasiswaResource($this->mahasiswa);
                }),
            ];
        }
    }
}
