<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Report extends Model
{
    use HasFactory;

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
}
