<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'school' => [
                'id' => $this->school->id,
                'name' => $this->school->name,
                'logo' => $this->school->image,
                'avg_rating' => (float) ($this->school->reviews_avg_rating ?? 0),
            ],
        ];
    }
}