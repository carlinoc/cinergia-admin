<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;
    protected $table = 'home_section';
    protected $primaryKey = 'id';

    public function movies(){
        return $this->belongsToMany('App\Models\Movie');
    }
}
