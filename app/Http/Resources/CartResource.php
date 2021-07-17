<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'total' => number_format($this->total / 100, 2),
            'products' => CartProductResource::collection($this->products) 
        ];
    }
}
