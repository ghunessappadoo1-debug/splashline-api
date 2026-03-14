<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
        protected $fillable = ['title','description','schedule_time','max_capacity'];

    public function registrations()
    {
        return $this->hasMany(TourRegistration::class);
    }
}
