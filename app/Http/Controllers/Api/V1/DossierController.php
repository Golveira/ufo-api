<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DossierRequest;
use App\Http\Resources\DossierResource;
use App\Models\Dossier;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class DossierController extends Controller
{
    public function index(): ResourceCollection
    {
        return DossierResource::collection(
            Dossier::with('user')->withCount('reports')->latest()->paginate()
        );
    }

    public function store(DossierRequest $request): DossierResource
    {
        return new DossierResource(
            $request->user()->dossiers()->create($request->validated())
        );
    }

    public function show(Dossier $dossier): DossierResource
    {
        return new DossierResource(
            $dossier->load('user')->loadCount('reports')
        );
    }

    public function update(DossierRequest $request, Dossier $dossier): DossierResource
    {
        $this->authorize('update', $dossier);

        $dossier->update($request->validated());

        return new DossierResource($dossier);
    }

    public function destroy(Dossier $dossier): Response
    {
        $this->authorize('delete', $dossier);

        $dossier->delete();

        return response()->noContent();
    }
}
