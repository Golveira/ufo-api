<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
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
     *
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
     * Returns a single user specified by the ID.
     *
     * @urlParam id string required The ID of the user. No-example
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     */
    public function show(User $user): UserResource
    {
        return new UserResource(
            $user->loadCount(['reports', 'dossiers'])
        );
    }
}
