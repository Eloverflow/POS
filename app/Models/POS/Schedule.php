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
            startDate,
            endDate,
            created_at,
            "12" as nbEmployees,
            "Current" as status
            '))
            ->get();
    }

}
