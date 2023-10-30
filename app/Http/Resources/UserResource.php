<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->when($request->user(), $this->email),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'reports_count' => $this->whenCounted('reports'),
            'dossiers_count' => $this->whenCounted('dossiers'),
        ];
    }
}
