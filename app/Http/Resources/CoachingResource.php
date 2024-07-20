<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoachingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'competition_name'=>$this->competition_name,
            'deadline_date'=>$this->deadline_date,
            'idea'=>$this->idea,
            'progress'=>$this->progress,
            'request'=>$this->request,
            'file'=>$this->file,
            'package_id'=>$this->package_id,
            'registrant_id'=>$this->registrant_id,
        ];
    }
}
