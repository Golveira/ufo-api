<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['liked'];

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
