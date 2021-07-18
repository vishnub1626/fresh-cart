<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_list_his_addresses()
    {
        $user = User::factory()->create();
        Address::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        Sanctum::actingAs($user);

        $this->json('GET', 'api/addresses')
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 10);
            });
    }
}
