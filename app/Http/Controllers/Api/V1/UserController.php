<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Users
 *
 * Endpoints for managing user.
 */
class UserController extends Controller
{
    /**
     * List users
     *
     * This endpoint allows you to get a list of users.
     *
     */
    public function index(): ResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->latest()
                ->paginate()
        );
    }

    /**
     * Get a user
     *
     * This endpoint allows you to get a user.
     *
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update a user
     *
     * This endpoint allows you to update a user.
     *
     * @authenticated
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new UserResource($user);
    }
}
