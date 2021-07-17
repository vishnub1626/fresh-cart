<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderProduct;
use Illuminate\Foundation\Bus\Dispatchable;

class PlaceOrder
{
    use Dispatchable;

    protected $cart;
    protected $orderType;
    protected $address;

    public function __construct(Cart $cart, string $orderType, Address $address)
    {
        $this->cart = $cart;
        $this->orderType = $orderType;
        $this->address = $address;
    }

    public function handle()
    {
        $order = Order::create([
            'user_id' => $this->cart->user_id,
            'type' => $this->orderType,
            'status' => 'pending',
            'address_id' => $this->address->id,
        ]);

        $this->cart->products->each(function ($product) use ($order) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id
            ]);
        });

        $order->total = $order->products->sum('price');
        $order->save();

        return $order;
    }
}
