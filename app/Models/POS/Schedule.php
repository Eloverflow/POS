<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['name', 'startDate', 'endDate'];

    public static function getById($id)
    {
        return \DB::table('schedules')
            ->join('employees', 'schedules.employee_id', '=', 'employees.id')
            ->join('employee_titles', 'employees.employeeTitle', '=', 'employee_titles.id')
            ->select(\DB::raw('employees.id as idEmployee,
            disponibilities.id as idDisponibility,
            disponibilities.created_at,
            disponibilities.updated_at,
            disponibilities.name,
            employees.salary,
            streetAddress,
            phone,
            firstName,
            lastName,
            employee_titles.name as employeeTitle,
            city,
            nas,
            pc,
            state,
            birthDate,
            hireDate,
            hireDate'))
            ->where('disponibilities.id', '=', $id)
            ->first();
    }

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

    public static function GetDaySchedules($id, $day_number)
    {
        $matches = ['schedule_id' => $id, 'day_number' => $day_number];
        return \DB::table('day_schedules')
            ->where($matches)
            ->get();
    }

    public static function GetDaySchedulesForEmployee($id, $day_number, $employeeId)
    {
        $matches = ['schedule_id' => $id, 'employee_id' => $employeeId, 'day_number' => $day_number];
        return \DB::table('day_schedules')
            ->where($matches)
            ->get();
    }
}
