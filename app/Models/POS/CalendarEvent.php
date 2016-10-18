<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{

    protected $table = 'calendar_events';

    protected $fillable = ['name', 'isAllDay', 'type', 'startTime', 'endTime','moment_type_id', 'employee_id'];

    public static function GetCalendarMoments()
    {
        return \DB::table('calendar_events')
            ->select(\DB::raw('calendar_events.*,
            employees.firstName,
            employees.lastName,
            moment_types.id as momentTypeId,
            moment_types.name as momentTypeName'))
            ->join('moment_types', 'calendar_events.moment_type_id', '=', 'moment_types.id')
            ->leftJoin('employees', 'calendar_events.employee_id', '=', 'employees.id')
            ->get();
    }

}
