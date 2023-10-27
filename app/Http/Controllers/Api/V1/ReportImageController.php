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
     * This endpoint allows you to get the images of a report.
     */
    public function index(Report $report): ResourceCollection
    {
        $images = $report->images()->latest()->get();

        return ImageResource::collection($images);
    }

    /**
     * Upload images
     *
     * This endpoint allows you to upload images
     *
     * @authenticated
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
     * This endpoint allows you to delete an image of a report.
     *
     * @authenticated
     */
    public function destroy(Report $report, Image $image): Response
    {
        $this->authorize('update', $report);

        $this->reportService->deleteImage($image);

        return response()->noContent();
    }
}
