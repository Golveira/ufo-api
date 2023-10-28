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
     * Get a list of dossiers of a user.
     * @urlParam user_id required The ID of the user. No-example
     * @apiResourceCollection App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier paginate=15
     */
    public function index(User $user): ResourceCollection
    {
        return DossierResource::collection(
            $user->dossiers()->withCount('reports')->latest()->paginate()
        );
    }
}
