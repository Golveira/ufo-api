<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'username' => User::generateUsername(),
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }
}
