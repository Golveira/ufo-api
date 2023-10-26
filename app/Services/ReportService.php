<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\MaxImagesUploadException;

class ReportService
{
    public function uploadImages(array $images, Report $report)
    {
        if (!$report->canUploadMoreImages(count($images))) {
            throw new MaxImagesUploadException;
        }

        foreach ($images as $image) {
            $path = $image->store('reports', 'public');

            $report->images()->create(['path' =>  $path]);
        }

        return $report->images;
    }

    public function deleteImage(Image $image): void
    {
        Storage::disk('public')->delete($image->path);

        $image->delete();
    }
}
