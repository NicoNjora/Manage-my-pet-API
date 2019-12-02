<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }

    public function vet()
    {
        return $this->belongsTo('App\Vet');
    }
}
