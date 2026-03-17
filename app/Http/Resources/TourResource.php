<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'max_participants' => $this->max_participants,
            'registrations_count' => $this->whenLoaded('registrations', $this->registrations->count()),
            'registrations' => TourRegistrationResource::collection($this->whenLoaded('registrations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}