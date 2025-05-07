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
        $thread->load(['user', 'category', 'posts.user']);
        return view('threads.show', compact('thread'));
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
}
