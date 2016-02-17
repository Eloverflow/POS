<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Day_Schedules extends Model
{
    //
    protected $table = 'day_schedules';
    protected $fillable = ['schedule_id', 'employee_id', 'day_number', 'startTime', 'endTime'];
}
