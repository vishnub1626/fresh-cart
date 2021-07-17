<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetOrderDetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_order_can_be_fetched()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $productOne = Product::factory()->create([
            'price' => 1000
        ]);
        $productTwo = Product::factory()->create([
            'price' => 2000
        ]);

        $cart->addProduct($productOne);
        $cart->addProduct($productTwo);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'pickup',
            'address' => [
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '123234',
            ],
        ]);

        $this->json('GET', 'api/orders/1')
            ->assertStatus(200)
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'status' => 'pending',
                    'type' => 'pickup',
                    'total' => '30.00',
                    'address' => [
                        'id' => 1,
                        'address_one' => 'Address One',
                        'address_two' => 'Address Two',
                        'city' => 'City',
                        'state' => 'State',
                        'pincode' => '123234',
                    ],
                    'products' => [
                        [
                            'id' => $productOne->id,
                            'name' => $productOne->name,
                            'price' => number_format($productOne->price / 100, 2),
                            'image' => $productOne->image,

                        ],
                        [
                            'id' => $productTwo->id,
                            'name' => $productTwo->name,
                            'price' => number_format($productTwo->price / 100, 2),
                            'image' => $productTwo->image,

                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function only_the_person_placed_the_order_can_see_the_order_details()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $productOne = Product::factory()->create([
            'price' => 1000
        ]);
        $productTwo = Product::factory()->create([
            'price' => 2000
        ]);

        $cart->addProduct($productOne);
        $cart->addProduct($productTwo);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'pickup',
            'address' => [
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '123234',
            ],
        ]);

        $anotherUser = User::factory()->create();
        Sanctum::actingAs($anotherUser);

        $this->json('GET', 'api/orders/1')
            ->assertStatus(403);
    }
}
