<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
        protected $fillable = ['visitor_id','ticket_id','visit_date','total_amount'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
