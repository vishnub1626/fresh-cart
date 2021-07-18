<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        return AddressResource::collection(
            Address::query()
            ->where('user_id', auth()->id())
            ->get()
        );
    }
}
