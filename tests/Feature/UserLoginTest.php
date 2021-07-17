<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login_and_get_an_api_token()
    {
        User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'somesecret',
        ]);

        $response = $this->json('POST', '/api/login', [
            'email' => 'john@example.com',
            'password' => 'somesecret',
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'token'
                ]
            ]);

        $token = explode('|', $response->json()['data']['token'])[1];

        $this->assertDatabaseHas('personal_access_tokens', [
            'token' => hash('sha256', $token),
        ]);
    }

    /** @test */
    public function email_field_is_required()
    {
        $this->json('POST', '/api/login', [
            'password' => 'somesecret',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function password_field_is_required()
    {
        $this->json('POST', '/api/login', [
            'email' => 'john@example.com',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function failed_validation_gives_401()
    {
        $this->json('POST', '/api/login', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ])->assertStatus(401);
    }
}
