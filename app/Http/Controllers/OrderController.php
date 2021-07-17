<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cart_id' => 'required', 
            'address' => 'required', 
            'type' => 'required|in:delivery,pickup', 
            'address.id' => 'sometimes|required|exists:addresses,id', 
            'address.address_one' => 'required_without:address.id',
            'address.city' => 'required_without:address.id',
            'address.state' => 'required_without:address.id',
            'address.pincode' => 'required_without:address.id',
        ]);

        $order = Order::createFromRequest($request);

        return new OrderResource($order);
    }
}
