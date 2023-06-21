<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentStudentResource extends JsonResource
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
            'mahasiswa' => $this->whenLoaded('mahasiswa', function () {
                return new MahasiswaResource($this->mahasiswa);
            }),
            'detailAssessmentStudent' => $this->whenLoaded('detail_nilai_mahasiswa', function () {
                return new DetailAssessmentStudentCollection($this->detail_nilai_mahasiswa);
            }),
            'assessmentPoint' => $this->whenLoaded('poin_penilaian', function(){
                return new AssessmentPointResource($this->poin_penilaian);
            }),
            'kelompok' => $this->whenLoaded('kelompok', function(){
                return new KelompokResource($this->kelompok);
            }),
            'score' => doubleval($this->nilai),
            'status' => boolval($this->approved_status)
        ];
    }
}
