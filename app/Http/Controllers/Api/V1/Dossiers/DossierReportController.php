<?php

namespace App\Http\Controllers\Api\V1\Dossiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Dossier;
use App\Models\Report;
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
     * Get a list of reports added to a dossier.
     *
     * @urlParam dossier_id required The ID of the dossier. No-example
     *
     * @apiResourceCollection App\Http\Resources\ReportResource
     *
     * @apiResourceModel App\Models\Report paginate=15
     */
    public function index(Dossier $dossier): ResourceCollection
    {
        return ReportResource::collection(
            $dossier->reports()
                ->withCount('images')
                ->latest()
                ->paginate()
        );
    }

    /**
     * Add a report to a dossier
     *
     * Add the specified report to a dossier.
     *
     * @authenticated
     *
     * @urlParam dossier_id required The ID of the dossier. No-example
     *
     * @response 204
     */
    public function store(AddReportRequest $request, Dossier $dossier): Response
    {
        $this->authorize('addReport', $dossier);

        $dossier->addReport($request->report_id);

        return response()->noContent();
    }

    /**
     * Remove a report from a dossier
     *
     * Remove the specified report from a dossier.
     *
     * @authenticated
     *
     * @urlParam dossier_id required The ID of the dossier. No-example
     *
     * @response 204
     */
    public function destroy(Dossier $dossier, Report $report): Response
    {
        $this->authorize('removeReport', $dossier);

        $dossier->removeReport($report->id);

        return response()->noContent();
    }
}
