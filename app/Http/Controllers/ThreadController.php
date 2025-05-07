<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with(['user', 'category'])->latest()->get();
        return view('threads.index', compact('threads'));
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
