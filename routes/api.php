<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    ThreadController,
    PostController
};

Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user',    [AuthController::class, 'user']);

    // Threads CRUD (except update)
    Route::apiResource('threads', ThreadController::class)
        ->except(['update']);

    // Nested posts under threads, shallow routes
    Route::apiResource('threads.posts', PostController::class)
        ->only(['store', 'destroy'])
        ->shallow();
});
