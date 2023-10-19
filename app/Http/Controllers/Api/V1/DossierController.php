<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
}
