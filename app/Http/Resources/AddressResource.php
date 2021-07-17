<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address_one' => $this->address_one,
            'address_two' => $this->address_two,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
        ];
    }
}
