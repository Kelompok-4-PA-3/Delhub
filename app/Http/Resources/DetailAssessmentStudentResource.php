<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailAssessmentStudentResource extends JsonResource
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
            'assessmentStudent' => $this->whenLoaded('nilai_mahasiswa', function () {
                return new AssessmentStudentResource($this->nilai_mahasiswa);
            }),
            'assessmentComponent' => $this->whenLoaded('komponen_nilai', function () {
                return new AssessmentComponentResource($this->komponen_nilai);
            }),
            'score' => doubleval($this->nilai),
        ];
    }
}
