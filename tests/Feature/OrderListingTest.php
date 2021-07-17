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
use Database\Factories\OrderProductFactory;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_order_can_be_placed_for_pickup_with_new_address()
    {
        $user = User::factory()->create();

        Order::factory()
            ->has(OrderProduct::factory()->count(3))
            ->create([
                'user_id' => $user->id
            ]);

        Order::factory()
            ->has(OrderProduct::factory()->count(1))
            ->create([
                'user_id' => $user->id
            ]);

        Sanctum::actingAs($user);

        $this->json('GET', 'api/orders')
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('meta')
                    ->has('links')
                    ->has('data', 2);
            });
    }
}
