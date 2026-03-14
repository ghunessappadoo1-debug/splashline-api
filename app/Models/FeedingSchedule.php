<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedingSchedule extends Model
{
        protected $fillable = ['animal_id','feeding_time','food_type'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
