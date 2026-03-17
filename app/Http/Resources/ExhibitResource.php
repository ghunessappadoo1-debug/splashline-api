<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'capacity' => $this->capacity,
            'animals' => AnimalResource::collection($this->whenLoaded('animals')),
            'feeding_schedules' => FeedingScheduleResource::collection($this->whenLoaded('feedingSchedules')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}