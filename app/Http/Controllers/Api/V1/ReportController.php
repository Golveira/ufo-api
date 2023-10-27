<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportListRequest;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Reports
 *
 * Endpoints for managing reports.
 */
class ReportController extends Controller
{
    /**
     * List reports
     *
     * This endpoint allows you to get a list of reports.
     */
    public function index(ReportListRequest $request): ResourceCollection
    {
        $reports = Report::query()
            ->withCount('images')
            ->search($request->validated())
            ->paginate();

        return ReportResource::collection($reports);
    }

    /**
     * Create a new report
     *
     * This endpoint allows you to create a new report.
     *
     * @authenticated
     */
    public function store(ReportRequest $request): ReportResource
    {
        $report = $request->user()
            ->reports()
            ->create($request->validated());

        return new ReportResource($report);
    }

    /**
     * Get a report
     *
     * This endpoint allows you to get a report.
     */
    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load('images'));
    }

    /**
     * Update a report
     *
     * This endpoint allows you to update a report.
     *
     * @authenticated
     */
    public function update(ReportRequest $request, Report $report): ReportResource
    {
        $this->authorize('update', $report);

        $report->update($request->validated());

        return new ReportResource($report->load('images'));
    }

    /**
     * Delete a report
     *
     * This endpoint allows you to delete a report.
     *
     *  @authenticated
     */
    public function destroy(Report $report): Response
    {
        $this->authorize('delete', $report);

        $report->delete();

        return response()->noContent();
    }
}
