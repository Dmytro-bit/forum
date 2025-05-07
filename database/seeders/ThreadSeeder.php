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
        $categories = Category::all();

        collect(range(1, 10))->each(function ($number) use ($user, $categories) {
            Thread::create([
                'title' => "Thread {$number}",
                'slug' => "thread-{$number}",
                'content' => "This is the content for thread {$number}.",
                'category_id' => $categories->random()->id,
                'user_id' => $user->id,
                'is_locked' => false,
                'is_pinned' => $number === 1
            ]);
        });
    }
}
