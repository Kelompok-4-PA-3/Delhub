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
            'ruangan' => $this->ruangan->nama,
            'deskripsi' => $this->deskripsi,
            'waktu' => Carbon::parse($this->waktu)->format('d-m-Y H:i'),
            'status' => $this->reference->value,
        ];
    }
}
