<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Requests\ReportListRequest;

class ReportController extends Controller
{
    public function index(ReportListRequest $request)
    {
        $reports = Report::query()
            ->search($request->validated())
            ->paginate();

        return ReportResource::collection($reports);
    }

    public function show(Report $report)
    {
        return new ReportResource($report);
    }
}
