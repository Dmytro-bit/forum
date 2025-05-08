<?php

use App\Http\Controllers\ChatGptController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ThreadController::class, 'index'])->name('home');

Route::get('/dashboard', [ThreadController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('threads', ThreadController::class);
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::get('/threads/chat-gpt', [ChatGptController::class, 'index'])->name('threads.chat.gpt');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/chat-gpt', [ChatGptController::class, 'chat'])->name('chat.gpt');
});
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads/{thread}/posts', [ThreadController::class, 'storePost'])->name('threads.posts.store');
require __DIR__ . '/auth.php';
