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
            'ruangan' => new RoomResource($this->ruangan),
            'kelompok' => new KelompokResource($this->kelompok),
            'description' => $this->description ?? '-',
            'waktu' => Carbon::parse($this->waktu)->format('D, d M Y H:i'),
            'status' => $this->reference->value,
        ];
    }
}
