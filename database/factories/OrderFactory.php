<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'type' => Arr::random(['pickup', 'delivery']),
            'status' => Arr::random(['pending', 'in_transit', 'delivered', 'cancelled']),
            'address_id' => Address::factory()->create(),
        ];
    }
}
