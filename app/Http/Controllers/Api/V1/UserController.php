<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        return UserResource::collection(
            User::query()
                ->latest()
                ->paginate()
        );
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return new UserResource($user);
    }
}
