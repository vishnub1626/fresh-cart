<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartProduct;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_can_be_added_to_a_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $product->id
        ]);

        $this->assertCount(1, Cart::all());
        $this->assertCount(1, CartProduct::all());
    }

    /** @test */
    public function a_product_can_be_removed_from_cart()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $product->id
        ]);

        $this->assertCount(1, Cart::all());
        $this->assertCount(1, CartProduct::all());

        $this->json('DELETE', "api/carts/products/{$product->id}")
            ->assertOk();

        $this->assertCount(0, Cart::all());
        $this->assertCount(0, CartProduct::all());
    }

    /** @test */
    public function cart_total_will_be_total_of_product_prices_in_cart()
    {
        $user = User::factory()->create();
        $productOne = Product::factory()->create([
            'price' => 1300
        ]);

        $productTwo = Product::factory()->create([
            'price' => 2200
        ]);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $productOne->id
        ]);
        $this->json('POST', 'api/carts/products', [
            'product_id' => $productTwo->id
        ]);

        $cart = Cart::first();
        $this->assertCount(2, $cart->products);
        $this->assertEquals(3500, $cart->total);
    }

    /** @test */
    public function only_a_valid_product_can_be_added_to_cart()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => 2
        ])->assertStatus(404);

        $this->assertCount(0, Cart::all());
        $this->assertCount(0, CartProduct::all());
    }

    /** @test */
    public function adding_a_product_retruns_the_whole_cart_object()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'price' => 1000
        ]);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $product->id
        ])->assertExactJson([
            'data' => [
                'id' => 1,
                'total' => '10.00',
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
    }

    /** @test */
    public function a_user_can_get_his_cart_information()
    {
        $user = User::factory()->create();
        $productOne = Product::factory()->create([
            'price' => 1000
        ]);
        $productTwo = Product::factory()->create([
            'price' => 2000
        ]);

        Sanctum::actingAs($user);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $productOne->id
        ]);

        $this->json('POST', 'api/carts/products', [
            'product_id' => $productTwo->id
        ]);

        $this->json('GET', 'api/carts')
            ->assertExactJson([
                'data' => [
                    'id' => 1,
                    'total' => '30.00',
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
}
