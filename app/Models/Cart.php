<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            CartProduct::class,
            'cart_id',
            'id',
            'id',
            'product_id'
        );
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function destroyCart()
    {
        $this->cartProducts()->delete();
        return $this->delete();
    }

    public function addProduct(Product $product)
    {
        $this->cartProducts()->create([
            'product_id' => $product->id
        ]);
    }

    public function recalculateTotal()
    {
        $this->total = $this->products->sum('price');
        $this->save();
    }

    public function removeProduct($productId)
    {
        $this->cartProducts()
            ->where('product_id', $productId)
            ->delete();

        if ($this->cartProducts()->count() == 0) {
            $this->delete();
        }
    }
}
