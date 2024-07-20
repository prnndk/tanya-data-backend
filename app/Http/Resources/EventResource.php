<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'event_type' => $this->event_type,
            'start_regist_time' => $this->start_regist_time->format('Y-m-d H:i:s'),
            'end_regist_time' => $this->end_regist_time->format('Y-m-d H:i:s'),
        ];
    }
}
