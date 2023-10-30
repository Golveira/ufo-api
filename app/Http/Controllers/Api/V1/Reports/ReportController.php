<?php

namespace App\Http\Controllers\Api\V1\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportListRequest;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
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
     * Get a list of reports.
     *
     * @apiResourceCollection App\Http\Resources\ReportResource
     *
     * @apiResourceModel App\Models\Report paginate=15
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
     * Create a report on behalf of the authenticated user.
     *
     * @authenticated
     *
     * @apiResource App\Http\Resources\ReportResource
     *
     * @apiResourceModel App\Models\Report
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
     * Returns a single report specified by the ID.
     *
     * @urlParam id string required The ID of the report. No-example
     *
     * @apiResource App\Http\Resources\ReportResource
     *
     * @apiResourceModel App\Models\Report with=images
     */
    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load('images'));
    }

    /**
     * Update a report
     *
     * Allows an authenticated user to update a report.
     *
     * @authenticated
     *
     * @urlParam id string required The ID of the report. No-example
     *
     * @apiResource App\Http\Resources\ReportResource
     *
     * @apiResourceModel App\Models\Report
     */
    public function update(ReportRequest $request, Report $report): ReportResource
    {
        $this->authorize('update', $report);

        $report->update($request->validated());

        return new ReportResource($report);
    }

    /**
     * Delete a report
     *
     * Allows an authenticated user to delete a report.
     *
     * @authenticated
     *
     * @urlParam id string required The ID of the report. No-example
     *
     * @response 204
     */
    public function destroy(Report $report): Response
    {
        $this->authorize('delete', $report);

        $report->delete();

        return response()->noContent();
    }
}
