<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function find()
    {
        $user = User::query()
            ->with('cart')
            ->find(auth()->id());

        return new CartResource($user->cart);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        $user = User::query()
            ->with('cart')
            ->find(auth()->id());

        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->createCart();
        }

        $cart->addProduct($product);

        return new CartResource($cart);
    }

    public function destroy($productId)
    {
        $user = User::query()
            ->with('cart')
            ->find(auth()->id());

        $user->cart->removeProduct($productId);

        return response()->json([
            'message' => 'Product removed from cart.'
        ]);
    }
}
