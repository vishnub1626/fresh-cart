<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\OrderProduct;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_order_can_be_placed_for_pickup_with_new_address()
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
        ])->assertStatus(201)
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

        $this->assertCount(1, Order::all());
        $this->assertCount(1, Address::all());
        $this->assertCount(2, OrderProduct::all());
    }

    /** @test */
    public function an_order_ca_be_placed_for_pickup_with_existing_address()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'type' => 'pickup'
        ]);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'pickup',
            'address' => $address->toArray(),
        ])->assertStatus(201)
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'status' => 'pending',
                    'type' => 'pickup',
                    'total' => '10.00',
                    'address' => [
                        'id' => $address->id,
                        'address_one' => $address->address_one,
                        'address_two' => $address->address_two,
                        'city' => $address->city,
                        'state' => $address->state,
                        'pincode' => $address->pincode,
                    ],
                    'products' => [
                        [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => number_format($product->price / 100, 2),
                            'image' => $product->image,

                        ]
                    ]
                ]
            ]);

        $this->assertCount(1, Order::all());
        $this->assertCount(1, Address::all());
    }

    /** @test */
    public function an_order_can_be_placed_for_delivery_with_new_address()
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
            'type' => 'delivery',
            'address' => [
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '123234',
            ],
        ])->assertStatus(201)
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'status' => 'pending',
                    'type' => 'delivery',
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

        $this->assertCount(1, Order::all());
        $this->assertCount(1, Address::all());
        $this->assertCount(2, OrderProduct::all());
    }

    /** @test */
    public function an_order_ca_be_placed_for_delivery_with_existing_address()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);
        $address = Address::factory()->create([
            'user_id' => $user->id,
            'type' => 'delivery',
        ]);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'delivery',
            'address' => $address->toArray(),
        ])->assertStatus(201)
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'status' => 'pending',
                    'type' => 'delivery',
                    'total' => '10.00',
                    'address' => [
                        'id' => $address->id,
                        'address_one' => $address->address_one,
                        'address_two' => $address->address_two,
                        'city' => $address->city,
                        'state' => $address->state,
                        'pincode' => $address->pincode,
                    ],
                    'products' => [
                        [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => number_format($product->price / 100, 2),
                            'image' => $product->image,

                        ]
                    ]
                ]
            ]);

        $this->assertCount(1, Order::all());
        $this->assertCount(1, Address::all());
    }

    /** @test */
    public function address_is_required_for_placing_an_order()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'delivery',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['address']);
    }

    /** @test */
    public function except_address_two_all_fields_in_address_are_required_if_no_id()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'delivery',
            'address' => [
                'adrress' => 'one'
            ]
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['address.address_one', 'address.city', 'address.state', 'address.pincode']);
    }

    /** @test */
    public function address_id_must_be_valid_if_present()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'delivery',
            'address' => [
                'id' => '123'
            ]
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['address.id']);
    }

    /** @test */
    public function cart_id_is_required()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'type' => 'delivery',
            'address' => [
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '123234',
            ],
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['cart_id']);
    }

    /** @test */
    public function type_must_be_one_of_delivery_or_pickup()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create([
            'user_id' => $user->id
        ]);

        $product = Product::factory()->create([
            'price' => 1000
        ]);

        $cart->addProduct($product);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/orders', [
            'cart_id' => $cart->id,
            'type' => 'error',
            'address' => [
                'address_one' => 'Address One',
                'address_two' => 'Address Two',
                'city' => 'City',
                'state' => 'State',
                'pincode' => '123234',
            ],
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['type']);
    }
}
