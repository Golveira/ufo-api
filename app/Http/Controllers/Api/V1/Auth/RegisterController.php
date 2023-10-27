<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

/**
 * @group Auth
 *
 * Endpoints for managing authentication.
 */
class RegisterController extends Controller
{
    /**
     * Register
     *
     * This endpoint allows you to register a new user.
     */
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
