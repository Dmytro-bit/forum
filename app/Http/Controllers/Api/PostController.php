<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // POST /api/threads/{thread}/posts
    public function store(StorePostRequest $request, Thread $thread): JsonResponse
    {
        $post = $thread->posts()
            ->create([
                'body'    => $request->body,
                'user_id' => Auth::id(),
            ]);

        return response()->json(['data' => $post], 201);
    }

    // DELETE /api/posts/{post}
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        // Return an **empty JSON** response with 204 status
        return response()->json(null, 204);
    }
}
