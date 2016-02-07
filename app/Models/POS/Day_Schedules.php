<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Day_Schedules extends Model
{
    //
    protected $table = 'day_schedules';
    protected $fillable = ['disponibility_id', 'day', 'day_number', 'startTime', 'endTime'];
}
