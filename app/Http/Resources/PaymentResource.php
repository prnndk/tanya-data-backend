<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'sender_name'=>$this->sender_name,
            'sender_bank'=>$this->sender_bank,
            'payment_bank_id'=>$this->payment_bank_id,
            'nominal'=>$this->nominal,
            'payment_proof'=>$this->payment_proof,
        ];
    }
}
