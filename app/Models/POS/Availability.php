<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $table = 'availability';
    protected $fillable = ['name', 'employee_id', 'created_at'];

    public static function getById($id)
    {
        return \DB::table('availability')
            ->join('employees', 'availability.employee_id', '=', 'employees.id')
            ->select(\DB::raw('employees.id as idEmployee,
            availability.id as idDisponibility,
            availability.created_at,
            availability.updated_at,
            availability.name,
            employees.bonusSalary,
            streetAddress,
            phone,
            firstName,
            lastName,
            city,
            nas,
            pc,
            state,
            birthDate,
            hireDate,
            hireDate'))
            ->where('availability.id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('availability')
            ->join('employees', 'availability.employee_id', '=', 'employees.id')
            ->select(\DB::raw('employees.id as idEmployee,
            availability.id as idDisponibility,
            availability.created_at,
            availability.updated_at,
            availability.name,
            employees.bonusSalary,
            streetAddress,
            phone,
            firstName,
            lastName,
            city,
            nas,
            pc,
            state,
            birthDate,
            hireDate,
            hireDate'))
            ->get();
    }

    public static function GetDayDisponibilities($id, $day_number)
    {
        $matches = ['availability_id' => $id, 'day_number' => $day_number];
        return \DB::table('day_availability')
            ->where($matches)
            ->get();
    }

    public static function GetDayDisponibilitiesForAll($day_number)
    {
        $matches = ['day_number' => $day_number];
        return \DB::table('day_availability')
            ->join('availability', 'day_availability.availability_id', '=', 'availability.id')
            ->join('employees', 'availability.employee_id', '=', 'employees.id')
            ->select(\DB::raw("availability_id, firstName, lastName, phone, date_format(startTime, '%H:%i') as startTime, date_format(endTime, '%H:%i') as endTime"))
            ->where($matches)
            ->orderBy('firstName', 'desc')
            ->orderBy('lastName', 'desc')
            ->get();
    }

    public static function GetDayDisponibilitiesForEmployee($day_number, $idEmployee)
    {
        $matches = ['employee_id' => $idEmployee, 'day_number' => $day_number];

        return \DB::table('day_availability')
            ->join('availability', 'day_availability.availability_id', '=', 'availability.id')
            ->select(\DB::raw("availability_id, firstName, lastName, phone, date_format(startTime, '%H:%i') as startTime, date_format(endTime, '%H:%i') as endTime"))
            ->join('employees', 'availability.employee_id', '=', 'employees.id')
            ->where($matches)
            ->orderBy('firstName', 'desc')
            ->get();
    }

    public static function DeleteDayDisponibilities($disponibilityId)
    {
        return \DB::table('day_availability')
            ->where('availability_id', '=', $disponibilityId)
            ->delete();
    }
    //
}
