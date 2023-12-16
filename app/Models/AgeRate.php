<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeRate extends Model
{
    use HasFactory;
    protected $table = 'agerates';
    protected $primaryKey = 'id';
}
