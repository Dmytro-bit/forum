<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Thread;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 users, each with 3 threads, each thread with 2 posts
        User::factory(5)->create()->each(function ($user) {
            Thread::factory(3)
                ->for($user)
                ->create()
                ->each(function ($thread) {
                    Post::factory(2)
                        ->for($thread)
                        ->for(User::factory())
                        ->create();
                });
        });
    }
}

