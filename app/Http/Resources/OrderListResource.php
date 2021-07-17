<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total' => number_format($this->total / 100, 2),
            'products' => OrderListProductResource::collection($this->products),
        ];
    }
}
