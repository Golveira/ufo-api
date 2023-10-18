<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportListRequest;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    public function index(ReportListRequest $request): AnonymousResourceCollection
    {
        $reports = Report::query()
            ->search($request->validated())
            ->paginate();

        return ReportResource::collection($reports);
    }

    public function store(ReportRequest $request): ReportResource
    {
        $report = $request
            ->user()
            ->reports()
            ->create($request->validated());

        return new ReportResource($report);
    }

    public function show(Report $report): ReportResource
    {
        return new ReportResource($report);
    }
}
