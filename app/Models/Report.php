<?php

namespace App\Models;

use App\Models\Dossier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'summary',
        'country',
        'state',
        'city',
        'lat',
        'long',
        'date',
        'duration',
        'object_shape',
        'number_of_observers',
        'details'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function dossiers(): BelongsToMany
    {
        return $this->belongsToMany(Dossier::class);
    }

    public function scopeSearch($query, array $filters)
    {
        return $query
            ->when($filters['keywords'] ?? false, function ($query) use ($filters) {
                return $query->where(function ($query) use ($filters) {
                    $query->where('summary', 'like', '%' . $filters['keywords'] . '%')
                        ->orWhere('details', 'like', '%' . $filters['keywords'] . '%');
                });
            })
            ->when($filters['country'] ?? false, function ($query) use ($filters) {
                return $query->where('country', $filters['country']);
            })
            ->when($filters['state'] ?? false, function ($query) use ($filters) {
                return $query->where('state', $filters['state']);
            })
            ->when($filters['city'] ?? false, function ($query) use ($filters) {
                return $query->where('city', $filters['city']);
            })
            ->when($filters['dateFrom'] ?? false, function ($query) use ($filters) {
                return $query->where('date', '>=', $filters['dateFrom']);
            })
            ->when($filters['dateTo'] ?? false, function ($query) use ($filters) {
                return $query->where('date', '<=', $filters['dateTo']);
            })
            ->when($filters['sortBy'] ?? false, function ($query) use ($filters) {
                return $query->orderBy($filters['sortBy'], $filters['sortOrder'] ?? 'asc');
            }, function ($query) {
                return $query->latest();
            });
    }
}
