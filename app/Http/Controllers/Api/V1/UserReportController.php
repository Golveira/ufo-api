<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserReportController extends Controller
{
    public function index(User $user): ResourceCollection
    {
        return ReportResource::collection(
            $user->reports()->latest()->paginate()
        );
    }
}
