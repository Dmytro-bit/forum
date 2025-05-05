<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadApiTest extends TestCase
{
//    use RefreshDatabase;

    protected function authHeaders(): array
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function test_guest_cannot_create_thread()
    {
        $this->postJson('/api/threads', [])
            ->assertStatus(401);
    }

    public function test_user_can_create_and_view_thread()
    {
        $headers = $this->authHeaders();

        $create = $this->withHeaders($headers)
            ->postJson('/api/threads', [
                'title' => 'Test Title',
                'body'  => 'Test body content',
            ]);
        $create->assertStatus(201)
            ->assertJsonPath('data.title', 'Test Title');

        $id = $create->json('data.id');

        $this->withHeaders($headers)
            ->getJson("/api/threads/$id")
            ->assertStatus(200)
            ->assertJsonPath('data.body', 'Test body content');
    }

    public function test_thread_pagination_works()
    {
        Thread::factory(25)->create();
        $this->getJson('/api/threads?per_page=5')
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }
}
