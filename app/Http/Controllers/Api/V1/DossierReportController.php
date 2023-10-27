<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Models\Dossier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Dossiers
 *
 * Endpoints for managing dossiers.
 */
class DossierReportController extends Controller
{
    /**
     * List dossier reports
     *
     * This endpoint allows you to get a list of reports attached to a dossier.
     *
     */
    public function index(Dossier $dossier): ResourceCollection
    {
        return ReportResource::collection(
            $dossier->reports()->latest()->paginate()
        );
    }

    /**
     * Add a report
     *
     * This endpoint allows you to add a report to a dossier.
     *
     * @authenticated
     */
    public function store(Request $request, Dossier $dossier): Response
    {
        $this->authorize('addReport', $dossier);

        $request->validate([
            'report_id' => ['required', 'exists:reports,id',],
        ]);

        $dossier->addReport($request->report_id);

        return response()->noContent();
    }

    /**
     * Remove a report
     *
     * This endpoint allows you to remove a report from a dossier.
     *
     * @authenticated
     */
    public function destroy(Dossier $dossier, Report $report): Response
    {
        $this->authorize('removeReport', $dossier);

        $dossier->removeReport($report->id);

        return response()->noContent();
    }
}
