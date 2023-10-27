<?php

namespace App\Http\Controllers\Api\V1;

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
     * This endpoint allows you to get a list of dossiers.
     *
     */
    public function index(): ResourceCollection
    {
        return DossierResource::collection(
            Dossier::with('user')->withCount('reports')->latest()->paginate()
        );
    }

    /**
     * Create a new dossier
     *
     * This endpoint allows you to create a new dossier.
     *
     * @authenticated
     */
    public function store(DossierRequest $request): DossierResource
    {
        return new DossierResource(
            $request->user()->dossiers()->create($request->validated())
        );
    }

    /**
     * Get a dossier
     *
     * This endpoint allows you to get a dossier.
     *
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
     * This endpoint allows you to update a dossier.
     *
     * @authenticated
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
     * This endpoint allows you to delete a dossier.
     *
     * @authenticated
     */
    public function destroy(Dossier $dossier): Response
    {
        $this->authorize('delete', $dossier);

        $dossier->delete();

        return response()->noContent();
    }
}
