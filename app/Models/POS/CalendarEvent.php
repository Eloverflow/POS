<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{

    protected $table = 'calendar_events';

    protected $fillable = ['name', 'isAllDay', 'type', 'startTime', 'endTime','moment_type_id', 'employee_id'];
}
