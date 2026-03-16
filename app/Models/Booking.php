<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
        protected $fillable = [ 'visitor_id', 'ticket_id', 'quantity', 'total_price'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
