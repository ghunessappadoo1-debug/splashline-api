<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
        protected $fillable = ['name','species','age','exhibit_id'];

    public function exhibit()
    {
        return $this->belongsTo(Exhibit::class);
    }

    public function feedingSchedules()
    {
        return $this->hasMany(FeedingSchedule::class);
    }
}
