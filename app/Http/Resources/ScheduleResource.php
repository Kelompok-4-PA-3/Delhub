<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'kelompok' => $this->kelompok->nama,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'ruangan' => $this->ruangan->nama,
        ];
    }
}
