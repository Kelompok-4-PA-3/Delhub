<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentPointResource extends JsonResource
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
            'name' => $this->nama_poin,
            'weight' => $this->bobot,
            'components' => $this->whenLoaded('komponen_penilaian', function () {
                return new AssessmentComponentCollection($this->komponen_penilaian);
            }),
        ];
    }
}
