<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth
 *
 * Endpoints for managing authentication.
 */
class LoginController extends Controller
{
    /**
     * Login
     *
     * This endpoint allows you to login a user.
     */
    public function store(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $request->user()->createToken('auth_token')->plainTextToken
        ], Response::HTTP_OK);
    }

    /**
     * Logout
     *
     * This endpoint allows you to logout a user.
     *
     * @authenticated
     */
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revoked'
        ], Response::HTTP_OK);
    }
}
