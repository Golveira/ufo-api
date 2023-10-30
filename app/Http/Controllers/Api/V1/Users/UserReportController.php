<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Reports
 *
 * Endpoints for managing reports.
 */
class UserReportController extends Controller
{
    /**
     * List reports for the authenticated user.
     *
     * Get a list of reports belonging to the authenticated user.
     *
     * @apiResourceCollection App\Http\Resources\ReportResource
     * @apiResourceModel App\Models\Report paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        return ReportResource::collection(
            $request->user()
                ->reports()
                ->withCount('images')
                ->latest()
                ->paginate()
        );
    }
}
