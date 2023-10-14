<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
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
