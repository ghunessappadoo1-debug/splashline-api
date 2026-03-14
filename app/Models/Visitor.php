<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
        protected $fillable = ['name','email','phone'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function tourRegistrations()
    {
        return $this->hasMany(TourRegistration::class);
    }
}
