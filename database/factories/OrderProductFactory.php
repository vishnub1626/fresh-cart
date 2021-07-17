<?php

namespace Database\Factories;

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory()->create(),
        ];
    }
}
