<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibit extends Model
{
        protected $fillable = ['name', 'type', 'description'];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
