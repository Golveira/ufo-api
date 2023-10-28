<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Image;
use App\Models\Report;
use App\Services\ReportService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

/**
 * @group Reports
 *
 * Endpoints for managing reports.
 */
class ReportImageController extends Controller
{
    public function __construct(private ReportService $reportService)
    {
    }

    /**
     * List report images
     *
     * Get the images of a report.
     * @urlParam report_id required The ID of the report. No-example
     * @apiResourceCollection App\Http\Resources\ImageResource
     * @apiResourceModel App\Models\Image paginate=15
     */
    public function index(Report $report): ResourceCollection
    {
        $images = $report->images()->latest()->get();

        return ImageResource::collection($images);
    }

    /**
     * Upload images
     *
     * Upload images for a report.
     *
     * @authenticated
     * @urlParam report_id required The ID of the report. No-example
     * @apiResourceCollection App\Http\Resources\ImageResource
     * @apiResourceModel App\Models\Image
     */
    public function store(StoreImageRequest $request, Report $report): ResourceCollection
    {
        $this->authorize('update', $report);

        $images  = $this->reportService->uploadImages($request->images, $report);

        return ImageResource::collection($images);
    }

    /**
     * Delete an image
     *
     * Delete an image of a report.
     *
     * @authenticated
     * @urlParam report_id required The ID of the report. No-example
     * @response 204
     */
    public function destroy(Report $report, Image $image): Response
    {
        $this->authorize('update', $report);

        $this->reportService->deleteImage($image);

        return response()->noContent();
    }
}
