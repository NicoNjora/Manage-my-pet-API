<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'name', 'details'
    ];

    public function dogs()
    {
        return $this->belongsToMany('App\Dog', 'dog_vaccine')->withTimestamps();
    }

}
