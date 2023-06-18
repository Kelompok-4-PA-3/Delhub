<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            'ruangan' => $this->whenLoaded('ruangan', function () {
                return new RoomResource($this->ruangan);
            }),
            'kelompok' => $this->whenLoaded('kelompok', function () {
                return new KelompokResource($this->kelompok);
            }),
            'description' => $this->description ?? '-',
            'waktu' => $this->waktu,
            'status' => $this->whenLoaded('reference', function () {
                return $this->reference->value;
            }),
            'result' => $this->hasil ?? '-',
            'is_done' => boolval($this->is_done),
            'file' => $this->file ? url(asset('uploads/bimbingan/' . $this->file)) : null,
        ];
    }
}
