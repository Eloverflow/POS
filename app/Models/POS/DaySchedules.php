<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class DaySchedules extends Model
{
    //
    protected $table = 'day_schedules';
    protected $fillable = ['schedule_id', 'employee_id', 'day_number', 'startTime', 'endTime'];
}
