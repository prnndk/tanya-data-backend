<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user'=>[
                'id'=>$this->id,
                'name'=>$this->name,
                'email'=>$this->email,
                'phone'=>$this->phone,
                'status'=>$this->status,
                'class'=>$this->class,
                'instansi'=>$this->instansi,
                'role'=>$this->role,
            ],
            'token_type'=>$this->token_type,
            'token'=>$this->token,
        ];
    }
}
