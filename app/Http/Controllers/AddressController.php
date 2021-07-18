<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::query()
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'data' => $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'type' => $address->type,
                    'address_one' => $address->address_one,
                    'address_two' => $address->address_two,
                    'city' => $address->city,
                    'state' => $address->state,
                    'pincode' => $address->pincode,
                ];
            })
        ]);
    }
}
