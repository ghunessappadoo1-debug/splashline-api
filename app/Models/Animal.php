<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'species', 'age', 'fun_fact', 'exhibit_id'];

    public function exhibit()
    {
        return $this->belongsTo(Exhibit::class);
    }

    public function feedingSchedules()
    {
        return $this->hasMany(FeedingSchedule::class);
    }
}