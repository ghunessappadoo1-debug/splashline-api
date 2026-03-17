<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourRegistration extends Model
{
    use HasFactory;

    protected $fillable = ['tour_id', 'visitor_id'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}