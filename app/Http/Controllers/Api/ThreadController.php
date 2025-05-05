<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThreadRequest;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    // GET /api/threads
    public function index(): JsonResponse
    {
        $threads = Thread::with('user')
            ->latest()
            ->paginate(request('per_page', 10));

        return response()->json($threads);
    }

    // POST /api/threads
    public function store(StoreThreadRequest $request): JsonResponse
    {
        $thread = Auth::user()
            ->threads()
            ->create($request->validated());

        return response()->json(['data' => $thread], 201);
    }

    // GET /api/threads/{thread}
    public function show(Thread $thread): JsonResponse
    {
        $thread->load(['user', 'posts.user']);
        return response()->json(['data' => $thread]);
    }

    // DELETE /api/threads/{thread}
    public function destroy(Thread $thread): \Illuminate\Http\Response
    {
        $this->authorize('delete', $thread);
        $thread->delete();
        return response()->noContent();
    }
}
