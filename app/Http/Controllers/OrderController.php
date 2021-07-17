<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Jobs\PlaceOrder;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Http\Requests\PlaceOrderRequest;
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

    public function store(PlaceOrderRequest $request)
    {
        $address = Address::createForOrder([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'address' => $request->get('address')
        ]);

        $order = PlaceOrder::dispatchSync(
            Cart::find($request->cart_id),
            $request->type,
            $address,
        );

        return new OrderResource($order);
    }

    public function update(Order $order, Request $request)
    {
        if (auth()->user()->cannot('update', $order)) {
            abort(403, 'You do not have permissions to update this order.');
        }

        if ($location = $request->get('location')) {
            $order->order_location = $location;
        }

        $order->status = $request->status;
        $order->save();


        $order->load('products', 'address');

        return new OrderResource($order);
    }
}
