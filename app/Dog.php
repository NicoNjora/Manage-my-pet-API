<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $fillable = [
        'name', 'breed', 'age'
    ];

    public function vaccines()
    {
        return $this->belongsToMany('App\Vaccine', 'dog_vaccine')->withTimestamps();
    }
}
