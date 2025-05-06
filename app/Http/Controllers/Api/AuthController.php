<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterRequest $req): \Illuminate\Http\JsonResponse
    {
        $user = User::create($req->validated());
        return response()->json(['user' => $user], 201);
    }

    // Login and issue a Sanctum token
    public function login(LoginRequest $req): \Illuminate\Http\JsonResponse
    {
        if (! Auth::attempt($req->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Auth::user()->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    // Return the authenticated user
    public function user()
    {
        return response()->json(Auth::user(), 200);
    }

    // Revoke all tokens (logout)
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->noContent();
    }
}

