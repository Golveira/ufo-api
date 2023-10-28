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
     * Get a list of users.
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User paginate=15
     */
    public function index(): ResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->withCount(['reports', 'dossiers'])
                ->latest()
                ->paginate()
        );
    }

    /**
     * Get a user
     *
     * Get a user by its ID.
     * @urlParam id required The ID of the user. No-example
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->loadCount(['reports', 'dossiers']));
    }

    /**
     * Update a user
     *
     * Update a user by its ID.
     *
     * @authenticated
     * @urlParam id required The ID of the user. No-example
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new UserResource($user);
    }
}
