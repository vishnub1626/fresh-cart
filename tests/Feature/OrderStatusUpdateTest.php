<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_order_status_can_be_updated_by_a_driver()
    {
        $customer = User::factory()->create([
            'type' => 'customer'
        ]);

        $order = Order::factory()
            ->has(OrderProduct::factory()->count(3))
            ->create([
                'status' => 'pending',
                'user_id' => $customer->id
            ]);

        $driver = User::factory()->create([
            'type' => 'driver'
        ]);

        Sanctum::actingAs($driver);

        $this->json('PUT', 'api/orders/' . $order->id, [
            'status' => 'in_transit'
        ])->assertStatus(200);

        $this->assertEquals('in_transit', $order->fresh()->status);
    }

    /** @test */
    public function a_driver_can_update_the_location_of_an_in_transit_order()
    {
        $customer = User::factory()->create([
            'type' => 'customer'
        ]);

        $order = Order::factory()
            ->has(OrderProduct::factory()->count(3))
            ->create([
                'status' => 'pending',
                'user_id' => $customer->id
            ]);

        $driver = User::factory()->create([
            'type' => 'driver'
        ]);

        Sanctum::actingAs($driver);

        $this->json('PUT', 'api/orders/' . $order->id, [
            'status' => 'in_transit',
            'location' => [
                'latitude' => 71.12,
                'longitude' => 73.34,
            ]
        ])->assertStatus(200);

        $this->assertEquals([
            'latitude' => 71.12,
            'longitude' => 73.34,
        ], $order->fresh()->order_location);
    }
}
