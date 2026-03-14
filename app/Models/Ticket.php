<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
        protected $fillable = ['ticket_type','price'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
