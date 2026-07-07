<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'description'=>$this->description,
            'phone'=>$this->phone,
            'website'=>$this->websit,
            'image'=>$this->image,
            'avg_rating'=>$this->reviews_avg_rating,
            'school_type'=>$this->schoolType?->name,
            'locations'=>LocationResource::collection($this->whenLoaded('locations')),
            'tuition_fees'=>TuitionFeesResource::collection($this->whenLoaded('tuition_fees')),
            'reviews'=>ReviewResource::collection($this->whenLoaded('reviews'))
        ];
    }
}
