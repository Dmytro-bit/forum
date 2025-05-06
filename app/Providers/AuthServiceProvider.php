<?php

namespace App\Providers;

use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Thread::class => ThreadPolicy::class,
        \App\Models\Post::class   => \App\Policies\PostPolicy::class,

    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
