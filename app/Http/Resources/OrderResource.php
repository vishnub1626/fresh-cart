<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'total' => number_format($this->total / 100, 2),
            'address' => new AddressResource($this->address),
            'location' => $this->order_location,
            'products' => OrderProductResource::collection($this->products),
        ];
    }
}
