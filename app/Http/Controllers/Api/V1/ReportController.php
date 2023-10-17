<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportListRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(ReportListRequest $request)
    {
        $reports = Report::query()
            ->search($request->validated())
            ->paginate();

        return ReportResource::collection($reports);
    }
}
