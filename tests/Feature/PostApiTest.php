<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
//    use RefreshDatabase;

    protected function authHeaders(User $user = null): array
    {
        $user  = $user ?? User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function test_user_can_reply_and_delete_own_post()
    {
        $user   = User::factory()->create();
        $thread = Thread::factory()->create();

        // Reply
        $res = $this->withHeaders($this->authHeaders($user))
            ->postJson("/api/threads/{$thread->id}/posts", [
                'body' => 'A reply here',
            ])
            ->assertStatus(201)
            ->assertJsonPath('data.body', 'A reply here');

        $postId = $res->json('data.id');

        // Delete own post
        $this->withHeaders($this->authHeaders($user))
            ->deleteJson("/api/posts/{$postId}")
            ->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $postId]);
    }

    public function test_user_cannot_delete_others_post()
    {
        $owner  = User::factory()->create();
        $post   = Post::factory()->create(['user_id' => $owner->id]);
        $other  = User::factory()->create();

        $this->withHeaders($this->authHeaders($other))
            ->deleteJson("/api/posts/{$post->id}")
            ->assertStatus(403);
    }
}
