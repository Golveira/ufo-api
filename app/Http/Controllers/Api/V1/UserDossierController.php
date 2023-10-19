<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\DossierResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserDossierController extends Controller
{
    public function index(User $user): ResourceCollection
    {
        return DossierResource::collection(
            $user->dossiers()->withCount('reports')->latest()->paginate()
        );
    }
}
