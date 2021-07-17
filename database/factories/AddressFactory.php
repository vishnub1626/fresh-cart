<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'type' => Arr::random(['pickup', 'delivery']),
            'address_one' => $this->faker->streetAddress(),
            'address_two' => null,
            'city' => $this->faker->city(),
            'state' => 'Kerala',
            'pincode' => $this->faker->postcode(),
        ];
    }
}
