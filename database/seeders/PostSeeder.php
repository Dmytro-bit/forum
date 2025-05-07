<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        $posts = [
            [
                'title' => 'First Post',
                'slug' => 'first-post',
                'content' => 'This is the first post content.',
                'category_id' => $categories->random()->id,
                'user_id' => $user->id
            ],
            [
                'title' => 'Second Post',
                'slug' => 'second-post',
                'content' => 'This is the second post content.',
                'category_id' => $categories->random()->id,
                'user_id' => $user->id
            ]
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
