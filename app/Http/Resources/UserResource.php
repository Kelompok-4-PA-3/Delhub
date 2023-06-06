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
        // check role is dosen or mahasiswa
        $role = $this->roles->first()->name;
        if ($role == 'dosen') {
            return [
                'id' => $this->id,
                'name' => $this->nama,
                'email' => $this->email,
                'role' => $role,
                'dosen' => $this->whenLoaded('dosen', function () {
                    return new DosenResource($this->dosen);
                }),
            ];
        } else if ($role == 'mahasiswa') {
            return [
                'id' => $this->id,
                'name' => $this->nama,
                'email' => $this->email,
                'role' => $role,
                'mahasiswa' => $this->whenLoaded('mahasiswa', function () {
                    return new MahasiswaResource($this->mahasiswa);
                }),
            ];
        }
    }
}
