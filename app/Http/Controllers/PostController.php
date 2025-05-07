<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function getNewPosts(Request $request, $threadId): \Illuminate\Http\JsonResponse
    {
        $lastPostId = $request->query('lastPostId', 0);

        $newPosts = Post::where('thread_id', $threadId)
            ->where('id', '>', $lastPostId)
            ->with('author')
            ->get();

        return response()->json($newPosts);
    }
    public function index(Request $request): Response
    {
        $query = Post::with(['user', 'category'])->latest();

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        return Inertia::render('Posts/Index', [
            'posts' => $query->paginate(10),
            'categories' => Category::all()
        ]);
    }
    public function create(): Response
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $request->user()->posts()->create($validated);

        return redirect()->route('posts.index');
    }

    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $post->load('user')
        ]);
    }

    public function edit(Post $post): Response
    {
        $this->authorize('update', $post);

        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
