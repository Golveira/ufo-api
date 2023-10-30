<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
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
     * Login a user.
     *
     * @response 200 { "access_token": "xxxxxxxx" }
     */
    public function store(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()
            ->createToken('auth_token')
            ->plainTextToken;

        return response()->json(['access_token' => $token], Response::HTTP_OK);
    }
}
