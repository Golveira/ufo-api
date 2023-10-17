<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'summary' => $this->summary,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'lat' => $this->lat,
            'long' => $this->long,
            'date' => $this->date,
            'duration' => $this->duration,
            'object_shape' => $this->object_shape,
            'number_of_observers' => $this->number_of_observers,
            'details' => $this->details,
        ];
    }
}
