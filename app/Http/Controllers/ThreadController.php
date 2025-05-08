<?php

namespace App\Http\Controllers;
use App\Models\Activity;

use App\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
class ThreadController extends Controller
{

    public function dashboard(): \Inertia\Response
    {
        $user = auth()->user();

        $threads = Thread::with('author')
            ->withCount('replies')
            ->latest('updated_at')
            ->get()
            ->map(fn($thread) => [
                'id' => $thread->id,
                'title' => $thread->title,
                'author' => ['name' => $thread->author->name],
                'replies_count' => $thread->replies_count,
                'last_activity' => $thread->updated_at->diffForHumans(),
                'is_pinned' => $thread->is_pinned
            ]);

        $popularThreads = Thread::popular()
            ->limit(5)
            ->get(['id', 'title']);


        $recentActivity = Activity::with(['user', 'subject'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                if (!$activity->subject) {
                    return "{$activity->user->name} performed an action";
                }

                $description = match ($activity->type) {
                    'created_thread' => $activity->subject ? "created thread \"{$activity->subject->title}\"" : "created a thread",
                    'created_post' => $activity->subject && $activity->subject->thread ? "commented on \"{$activity->subject->thread->title}\"" : "commented on a thread",
                    'joined_forum' => "joined the forum",
                    default => $activity->description ?? 'performed an action'
                };

                return "{$activity->user->name} {$description}";
            });

        $stats = [
            'threads_count' => Thread::where('user_id', $user->id)->count(),
            'replies_count' => \App\Models\Post::where('user_id', $user->id)->count() // Changed Reply to Post
        ];

        return Inertia::render('Dashboard', [
            'auth' => ['user' => $user],
            'threads' => $threads,
            'popularThreads' => $popularThreads,
            'recentActivity' => $recentActivity,
            'stats' => $stats
        ]);
    }
    public function index()
    {

        $threads = Thread::with('author')
            ->withCount('replies')
            ->latest('updated_at')
            ->get()
            ->map(fn($thread) => [
                'id' => $thread->id,
                'title' => $thread->title,
                'author' => ['name' => $thread->author->name],
                'replies_count' => $thread->replies_count,
                'last_activity' => $thread->updated_at->diffForHumans(),
                'is_pinned' => $thread->is_pinned
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


        return Inertia::render('Home', [
            'threads' => $threads,
            'popularThreads' => $popularThreads,
            'recentActivity' => $recentActivity,
            'auth' => [
                'user' => auth()->user()
            ]
        ]);  }


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
            'auth' => ['user' => auth()->user()], // Pass the auth object
        ]);
    }

    public function create()
    {
        return inertia('Forum/Create');
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Incoming request data:', $request->all());

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|min:3',
            'content' => 'required|min:3',
        ]);

        // Log the validated data
        Log::info('Validated data:', $validated);

        // Add additional fields
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        $validated['user_id'] = $request->user()->id;

        // Create the thread
        $thread = Thread::create($validated);

        // Log the created thread
        Log::info('Thread created:', $thread->toArray());

        // Redirect to the thread's show page
        return redirect()->route('threads.show', $thread);
    }

    public function storePost(Request $request, Thread $thread)
    {
        $request->validate(['body' => 'required|string']);

        $new = $thread->replies()->create([
            'user_id' => auth()->id(),
            'content'    => $request->body,
        ]);

        event(new \App\Events\PostCreated($new));

        return response()->json(['status' => 'ok'], 200);
    }

}
