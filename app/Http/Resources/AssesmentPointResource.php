<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssesmentPointResource extends JsonResource
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
            'nama' => $this->nama_poin,
            'bobot' => $this->bobot,
            'komponen_penilaian' => $this->whenLoaded('komponen_penilaian', function () {
                return new AssesmentComponentCollection($this->komponen_penilaian);
            }),
        ];
    }
}
