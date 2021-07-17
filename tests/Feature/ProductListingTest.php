<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductListingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_list_the_products()
    {
        Product::factory()->count(60)->create();

        $response = $this->json('GET', '/api/products')
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }
}
