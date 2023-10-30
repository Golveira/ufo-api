<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\DossierResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Dossiers
 *
 * Endpoints for managing dossiers.
 */
class UserDossierController extends Controller
{
    /**
     * List dossiers for the authenticated user.
     *
     * Get a list of dossiers belonging to the authenticated user.
     *
     * @apiResourceCollection App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        return DossierResource::collection(
            $request->user()
                ->dossiers()
                ->withCount('reports')
                ->latest()
                ->paginate()
        );
    }
}
