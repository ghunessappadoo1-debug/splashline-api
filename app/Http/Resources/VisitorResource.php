<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
            'tour_registrations' => TourRegistrationResource::collection($this->whenLoaded('tourRegistrations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}