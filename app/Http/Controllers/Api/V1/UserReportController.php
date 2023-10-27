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
     * This endpoint allows you to get a list of reports of a user.
     *
     */
    public function index(User $user): ResourceCollection
    {
        return ReportResource::collection(
            $user->reports()->latest()->paginate()
        );
    }
}
