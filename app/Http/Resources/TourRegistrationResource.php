<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourRegistrationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tour' => new TourResource($this->whenLoaded('tour')),
            'visitor' => new VisitorResource($this->whenLoaded('visitor')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}