<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with('author')
            ->withCount('replies')
            ->latest('updated_at')
            ->get()
            ->map(fn($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'author' => ['name' => $t->author->name],
                'replies_count' => $t->replies_count,
                'last_activity' => $t->updated_at->diffForHumans(),
            ]);

        $popularThreads = Thread::withCount('replies')
            ->orderBy('replies_count', 'desc')
            ->limit(5)
            ->get(['id', 'title']);

        $recentActivity = [
            'New comment on "Thread Title 1"',
            'Alice Smith joined the forum',
            'John Doe updated his profile picture',
        ];

        return Inertia::render('Forum/Index', compact('threads', 'popularThreads', 'recentActivity'));
    }


    public function show(Thread $thread)
    {
        $thread->load(['author', 'replies.author']);
        $posts = $thread->replies->map(fn($post) => [
            'id' => $post->id,
            'author' => ['name' => $post->author->name, 'avatar' => $post->author->avatar_url],
            'body' => $post->body,
            'created_at' => $post->created_at->format('H:i A'),
        ]);

        $sidebarThreads = Thread::where('id', '!=', $thread->id)
            ->latest('updated_at')
            ->limit(10)
            ->get(['id', 'title']);

        return Inertia::render('Forum/Show', [
            'thread' => ['id' => $thread->id, 'title' => $thread->title],
            'posts' => $posts,
            'sidebarThreads' => $sidebarThreads,
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $thread = $request->user()->threads()->create($validated);
        return redirect()->route('threads.show', $thread);
    }

    public function storePost(Request $request, Thread $thread)
    {
        $request->validate(['body' => 'required|string']);
        $new = $thread->replies()->create([
            'user_id' => auth()->id(),
            'content' => $request->body,
        ]);
        echo 'PostCreated event firing for thread ' . $thread->id;

        event(new \App\Events\PostCreated($new));  // ← pass $new, not $thread

        return redirect()->route('threads.show', $thread);
    }

}
