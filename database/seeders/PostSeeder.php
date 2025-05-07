<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $threads = Thread::all();

        foreach ($threads as $thread) {
            Post::create([
                'title' => "Reply to {$thread->title}",
                'slug' => "reply-to-" . $thread->slug,
                'content' => "This is a reply to {$thread->title}.",
                'thread_id' => $thread->id,
                'user_id' => $user->id
            ]);
        }
    }
}
