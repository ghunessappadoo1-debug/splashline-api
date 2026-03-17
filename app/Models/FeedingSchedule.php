<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['exhibit_id', 'animal_id', 'feeding_time', 'food_type'];

    protected $casts = [
        'feeding_time' => 'datetime:H:i',
    ];

    public function exhibit()
    {
        return $this->belongsTo(Exhibit::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}