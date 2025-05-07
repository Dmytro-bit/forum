<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ThreadController;

Route::get('/', [ThreadController::class, 'index'])->name('home');

Route::get('/dashboard', [ThreadController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('threads', ThreadController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::get('/threads/{threadId}/new-posts', [PostController::class, 'getNewPosts']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads/{thread}/posts', [ThreadController::class, 'storePost'])->name('threads.posts.store');
require __DIR__.'/auth.php';
