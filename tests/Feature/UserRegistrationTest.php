<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_new_user_can_register()
    {
        $this->json('POST', '/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'somesecret',
        ])->assertStatus(201)
        ->assertExactJson([
            'data' => [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]
        ]);

        $this->assertCount(1, User::all());

        $user = User::first();

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    /** @test */
    public function name_field_is_required()
    {
        $this->json('POST', '/api/users', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function email_field_is_required()
    {
        $this->json('POST', '/api/users', [
            'name' => 'John Doe',
            'password' => 'secret',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function password_field_is_required()
    {
        $this->json('POST', '/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function password_must_be_min_8_characters()
    {
        $this->json('POST', '/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
        ])->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function password_must_be_hashed()
    {
        $this->json('POST', '/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'somesecret',
        ]);

        $user = DB::table('users')->first();

        $this->assertTrue(Hash::check('somesecret', $user->password));
    }
}
