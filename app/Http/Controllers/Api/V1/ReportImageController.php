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

class ReportImageController extends Controller
{
    public function __construct(private ReportService $reportService)
    {
    }

    public function index(Report $report): ResourceCollection
    {
        $images = $report->images()->latest()->get();

        return ImageResource::collection($images);
    }

    public function store(StoreImageRequest $request, Report $report): ResourceCollection
    {
        $this->authorize('update', $report);

        $images  = $this->reportService->uploadImages($request->images, $report);

        return ImageResource::collection($images);
    }

    public function destroy(Report $report, Image $image): Response
    {
        $this->authorize('update', $report);

        $this->reportService->deleteImage($image);

        return response()->noContent();
    }
}
