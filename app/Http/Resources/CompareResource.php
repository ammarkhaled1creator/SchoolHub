<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'school_type'=>$this->schoolType?->name,
            'avg_rating' => round((float) $this->reviews_avg_rating, 1),
            'image'=>$this->image,
            'locations'=>LocationResource::collection($this->whenLoaded('locations')),
            'tuition_fees'=>TuitionFeesResource::collection($this->whenLoaded('tuition_fees')),
            'reviews'=>ReviewResource::collection($this->whenLoaded('reviews')),


        ];
    }
}
