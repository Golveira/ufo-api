<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportListRequest;
use App\Http\Requests\ReportRequest;
use App\Services\ReportService;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService)
    {
    }

    public function index(ReportListRequest $request): ResourceCollection
    {
        $reports = $this->reportService->getReports($request->validated());

        return ReportResource::collection($reports);
    }

    public function store(ReportRequest $request): ReportResource
    {
        $report = $this->reportService->createReport($request->validated());

        return new ReportResource($report);
    }

    public function show(Report $report): ReportResource
    {
        return new ReportResource($report->load('images'));
    }

    public function update(ReportRequest $request, Report $report): ReportResource
    {
        $this->authorize('update', $report);

        $report = $this->reportService->updateReport($request->validated(), $report);

        return new ReportResource($report->load('images'));
    }

    public function destroy(Report $report): Response
    {
        $this->authorize('delete', $report);

        $report->delete();

        return response()->noContent();
    }
}
