<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\DossierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Users
 *
 * Endpoints for managing user.
 */
class UserDossierController extends Controller
{
    /**
     * List user dossiers
     *
     * This endpoint allows you to get a list of dossiers of a user.
     *
     */
    public function index(User $user): ResourceCollection
    {
        return DossierResource::collection(
            $user->dossiers()->withCount('reports')->latest()->paginate()
        );
    }
}
