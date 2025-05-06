<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_and_login_flow()
    {
        // Register
        $this->postJson('/api/register', [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'secret123!',
            'password_confirmation' => 'secret123!',
        ])->assertStatus(201)
            ->assertJsonStructure(['user' => ['id','name','email']]);

        // Login
        $response = $this->postJson('/api/login', [
            'email' => 'alice@example.com',
            'password' => 'secret123!',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure(['token']);

        // Fetch user via token
        $token = $response->json('token');
        $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/user')
            ->assertStatus(200)
            ->assertJson(['email' => 'alice@example.com']);
    }
}
