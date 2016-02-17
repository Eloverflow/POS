<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['name', 'startDate', 'endDate'];

    public static function getAll()
    {
        return \DB::table('schedules')
            ->select(\DB::raw('schedules.id as idSchedule,
            name,
            startDate,
            endDate,
            schedules.created_at,
            count(day_schedules.employee_id) as "nbEmployees",
            "fakestatus" as status
            '))
            ->join('day_schedules', 'schedules.id', '=', 'day_schedules.schedule_id')
            ->get();
    }

}
