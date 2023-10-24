<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\MaxImagesUploadException;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportService
{
    public function getReports(array $filters): LengthAwarePaginator
    {
        $reports = Report::query()
            ->withCount('images')
            ->search($filters)
            ->paginate();

        return $reports;
    }

    public function createReport(array $data): Report
    {
        $report = Auth::user()->reports()->create($data);

        if (isset($data['images'])) {
            $this->uploadImages($data['images'], $report);
        }

        return $report;
    }

    public function updateReport(array $data, Report $report): Report
    {
        $report->update($data);

        if (isset($data['images'])) {
            $this->uploadImages($data['images'], $report);
        }

        return $report;
    }

    private function uploadImages(array $images, Report $report)
    {
        if (!$report->canUploadMoreImages(count($images))) {
            throw new MaxImagesUploadException;
        }

        foreach ($images as $image) {
            $path = $image->store('reports', 'public');

            $report->images()->create(['path' =>  $path]);
        }
    }
}
