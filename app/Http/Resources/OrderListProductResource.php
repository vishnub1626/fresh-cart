<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'price' => number_format($this->price / 100, 2),
        ];
    }
}
