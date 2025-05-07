<?php

namespace Database\Seeders;

use App\Models\Thread;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ThreadSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        collect(range(1, 10))->each(function ($number) use ($user) {
            Thread::create([
                'title' => "Thread {$number}",
                'slug' => "thread-{$number}",
                'content' => "This is the content for thread {$number}.",
                'user_id' => $user->id,
                'is_locked' => false,
                'is_pinned' => $number === 1
            ]);
        });
    }
}
