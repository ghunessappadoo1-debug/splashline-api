<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['visitor_id', 'ticket_id', 'visit_date', 'quantity', 'total_price', 'status'];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}