<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Profile/Edit', [
            'status' => 'success',
        ]);
    }

    public function update(Request $request): Response
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
        ]);

        if ($data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->fill($data)->save();

        return Inertia::render('Profile/Edit', [
            'status'  => 'success',
            'message' => 'Profile updated successfully.',
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required','current_password'],
        ]);

        // 🔴 grab the user BEFORE you logout
        $user = $request->user();

        Auth::logout();

        // 🔴 delete the real model, not null
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
