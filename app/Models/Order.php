<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderProduct::class,
            'order_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public static function createFromRequest($request)
    {
        $cart = Cart::with('products')->findOrFail($request->cart_id);

        $address = Address::createForOrder([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'address' => $request->get('address')
        ]);


        $order = static::create([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'status' => 'pending',
            'address_id' => $address->id,
        ]);

        $cart->products->each(function ($product) use ($order) {
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
