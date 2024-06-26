<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_code' => $this->phone_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'image' => '',
            'lat' => $this->lat,
            'lon' => $this->lon,
            'rider_note' => $this->rider_note
        ];
    }
}
