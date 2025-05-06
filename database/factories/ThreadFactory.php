<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'user_id' => User::factory(),
            'title'   => $title,
            'slug'    => Str::slug($title),
            'body'    => $this->faker->paragraphs(3, true),
        ];
    }
}
