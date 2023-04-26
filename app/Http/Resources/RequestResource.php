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
            'deskripsi' => $this->description ?? '-',
            'waktu' => $this->time->format('D, d M Y H:i'),
            'status' => $this->reference->value,
        ];
    }
}
