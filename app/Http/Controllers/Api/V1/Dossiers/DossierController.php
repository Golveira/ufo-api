<?php

namespace App\Http\Controllers\Api\V1\Dossiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DossierRequest;
use App\Http\Resources\DossierResource;
use App\Models\Dossier;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Dossiers
 *
 * Endpoints for managing dossiers.
 */
class DossierController extends Controller
{
    /**
     * List dossiers
     *
     * Get a list of dossiers.
     *
     * @apiResourceCollection App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier with=user paginate=15
     */
    public function index(): ResourceCollection
    {
        return DossierResource::collection(
            Dossier::with('user')
                ->withCount('reports')
                ->latest()
                ->paginate()
        );
    }

    /**
     * Create a new dossier
     *
     * Create a new dossier on behalf of the authenticated user.
     *
     * @authenticated
     * @apiResource App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier
     */
    public function store(DossierRequest $request): DossierResource
    {
        return new DossierResource(
            $request->user()
                ->dossiers()
                ->create($request->validated())
        );
    }

    /**
     * Get a dossier
     *
     * Returns a single dossier specified by the ID.
     *
     * @urlParam id required The ID of the dossier. No-example
     * @apiResource App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier with=user
     */
    public function show(Dossier $dossier): DossierResource
    {
        return new DossierResource(
            $dossier->load('user')->loadCount('reports')
        );
    }

    /**
     * Update a dossier
     *
     * Allows an authenticated user to update a dossier.
     *
     * @authenticated
     * @urlParam id required The ID of the dossier. No-example
     * @apiResource App\Http\Resources\DossierResource
     * @apiResourceModel App\Models\Dossier
     */
    public function update(DossierRequest $request, Dossier $dossier): DossierResource
    {
        $this->authorize('update', $dossier);

        $dossier->update($request->validated());

        return new DossierResource($dossier);
    }

    /**
     * Delete a dossier
     *
     * Allows an authenticated user to delete a dossier.
     *
     * @authenticated
     * @urlParam id required The ID of the dossier. No-example
     * @response 204
     */
    public function destroy(Dossier $dossier): Response
    {
        $this->authorize('delete', $dossier);

        $dossier->delete();

        return response()->noContent();
    }
}
