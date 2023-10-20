<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Models\Dossier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class DossierReportController extends Controller
{
    public function index(Dossier $dossier): ResourceCollection
    {
        return ReportResource::collection(
            $dossier->reports()->latest()->paginate()
        );
    }

    public function store(Request $request, Dossier $dossier): Response
    {
        $this->authorize('addReport', $dossier);

        $request->validate([
            'report_id' => ['required', 'exists:reports,id',],
        ]);

        $dossier->addReport($request->report_id);

        return response()->noContent();
    }

    public function destroy(Dossier $dossier, Report $report): Response
    {
        $this->authorize('removeReport', $dossier);

        $dossier->removeReport($report->id);

        return response()->noContent();
    }
}
