<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    ThreadController,
    PostController
};

//
// Public Thread endpoints (no auth)
//
Route::get('threads',          [ThreadController::class, 'index']);
Route::get('threads/{thread}', [ThreadController::class, 'show']);

//
// Auth endpoints
//
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

//
// Protected (requires Sanctum token)
//
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user',    [AuthController::class, 'user']);

    // Thread write/delete
    Route::post('threads',            [ThreadController::class, 'store']);
    Route::delete('threads/{thread}', [ThreadController::class, 'destroy']);

    // Posts write/delete
    Route::post('threads/{thread}/posts', [PostController::class, 'store']);
    Route::delete('posts/{post}',         [PostController::class, 'destroy']);
});
