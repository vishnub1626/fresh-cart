<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderListResource;

class OrderController extends Controller
{
    public function find(Order $order)
    {
        if (auth()->user()->cannot('view', $order)) {
            abort(403, 'You do not have permissions to view this order.');
        }

        $order->load('products', 'address');

        return new OrderResource($order);
    }

    public function index()
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return OrderListResource::collection($orders);
    }

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
