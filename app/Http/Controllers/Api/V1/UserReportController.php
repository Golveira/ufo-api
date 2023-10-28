<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @group Users
 *
 * Endpoints for managing users.
 */
class UserReportController extends Controller
{
    /**
     * List user reports
     *
     * Get a list of reports of a user.
     * @urlParam user_id required The ID of the user. No-example
     * @apiResourceCollection App\Http\Resources\ReportResource
     * @apiResourceModel App\Models\Report paginate=15
     */
    public function index(User $user): ResourceCollection
    {
        return ReportResource::collection(
            $user->reports()->latest()->paginate()
        );
    }
}
