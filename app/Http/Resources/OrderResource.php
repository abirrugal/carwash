<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'package_name' => $this->package_name,
            'package_details' => $this->package_details,
            'package_price' => $this->package_price,
            'package_working_time' => $this->package_work_time,
            'tips' => $this->tips,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'additionals' => OrderAdditionalResource::collection($this->additionals),         
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'order_date' => $this->created_at,
        ];
    }
}
