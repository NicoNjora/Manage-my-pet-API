<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
    */
    protected $dates = ['date_born'];

    protected $fillable = [
        'name', 'breed', 'age', 'date_born', 'gender'
    ];

    public function vaccines()
    {
        return $this->belongsToMany('App\Vaccine', 'pet_vaccine')->withTimestamps();
    }
}
