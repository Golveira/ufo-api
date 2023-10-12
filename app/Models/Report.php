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
}
