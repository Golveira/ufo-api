<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dossier extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class);
    }

    public function addReport(string $reportId): void
    {
        if (!$this->hasReport($reportId)) {
            $this->reports()->attach($reportId);
        }
    }

    public function removeReport(string $reportId): void
    {
        $this->reports()->detach($reportId);
    }

    public function hasReport(string $reportId): bool
    {
        return $this->reports()->where('report_id', $reportId)->exists();
    }
}
