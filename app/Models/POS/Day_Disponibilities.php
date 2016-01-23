<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Day_Disponibilities extends Model
{
    //
    protected $table = 'day_disponibilities';
    protected $fillable = ['disponibility_id', 'day', 'day_number', 'startTime', 'endTime'];
}
