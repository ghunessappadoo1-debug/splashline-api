<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'location', 'capacity'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function feedingSchedules()
    {
        return $this->hasMany(FeedingSchedule::class);
    }
}