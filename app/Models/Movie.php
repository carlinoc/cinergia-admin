<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function captions(){
        return $this->belongsToMany('App\Models\Caption');
    }

    public function genres(){
        return $this->belongsToMany('App\Models\Genre');
    }

    public function packages(){
        return $this->belongsToMany('App\Models\Package');
    }

    public function clients(){
        return $this->belongsToMany('App\Models\Client');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId');
    }
}
