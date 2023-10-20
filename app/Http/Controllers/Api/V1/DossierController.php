<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DossierRequest;
use App\Http\Resources\DossierResource;
use App\Models\Dossier;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
}
