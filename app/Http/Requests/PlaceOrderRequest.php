<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cart_id' => 'required|exists:carts,id', 
            'address' => 'required', 
            'type' => 'required|in:delivery,pickup', 
            'address.id' => 'sometimes|required|exists:addresses,id', 
            'address.address_one' => 'required_without:address.id',
            'address.city' => 'required_without:address.id',
            'address.state' => 'required_without:address.id',
            'address.pincode' => 'required_without:address.id',
        ];
    }
}
