<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

/**
 * @group Users
 *
 * Endpoints for managing user.
 */
class AuthenticatedUserController extends Controller
{
    /**
     * Get the authenticated user.
     *
     * Returns the authenticated user.
     *
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function show(Request $request): UserResource
    {
        return new UserResource(
            $request->user()->loadCount(['reports', 'dossiers'])
        );
    }

    /**
     * Update the authenticated user.
     *
     * Update the email and password of the authenticated user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function update(UserRequest $request): UserResource
    {
        $request->user()->update($request->validated());

        return new UserResource($request->user());
    }
}
