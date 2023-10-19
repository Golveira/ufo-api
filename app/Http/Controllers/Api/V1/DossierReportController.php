<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Dossier;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DossierReportController extends Controller
{
    public function index(Dossier $dossier): ResourceCollection
    {
        return ReportResource::collection(
            $dossier->reports()->latest()->paginate()
        );
    }
}
