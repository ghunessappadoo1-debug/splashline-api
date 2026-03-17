<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedingScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'exhibit' => new ExhibitResource($this->whenLoaded('exhibit')),
            'animal' => new AnimalResource($this->whenLoaded('animal')),
            'feeding_time' => $this->feeding_time->format('H:i'),
            'food_type' => $this->food_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}