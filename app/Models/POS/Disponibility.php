<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Disponibility extends Model
{
    protected $table = 'disponibilities';
    protected $fillable = ['name', 'employee_id', 'created_at'];

    public static function getById($id)
    {
        return \DB::table('disponibilities')
            ->join('employees', 'disponibilities.employee_id', '=', 'employees.id')
            ->select(\DB::raw('employees.id as idEmployee,
            disponibilities.id as idDisponibility,
            disponibilities.created_at,
            disponibilities.updated_at,
            disponibilities.name,
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
            ->where('disponibilities.id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('disponibilities')
            ->join('employees', 'disponibilities.employee_id', '=', 'employees.id')
            ->select(\DB::raw('employees.id as idEmployee,
            disponibilities.id as idDisponibility,
            disponibilities.created_at,
            disponibilities.updated_at,
            disponibilities.name,
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
        $matches = ['disponibility_id' => $id, 'day_number' => $day_number];
        return \DB::table('day_disponibilities')
            ->where($matches)
            ->get();
    }

    public static function GetDayDisponibilitiesForAll($day_number)
    {
        $matches = ['day_number' => $day_number];
        return \DB::table('day_disponibilities')
            ->join('disponibilities', 'day_disponibilities.disponibility_id', '=', 'disponibilities.id')
            ->join('employees', 'disponibilities.employee_id', '=', 'employees.id')
            ->select(\DB::raw("disponibility_id, firstName, lastName, phone, date_format(startTime, '%H:%i') as startTime, date_format(endTime, '%H:%i') as endTime"))
            ->where($matches)
            ->orderBy('firstName', 'desc')
            ->orderBy('lastName', 'desc')
            ->get();
    }

    public static function GetDayDisponibilitiesForEmployee($day_number, $idEmployee)
    {
        $matches = ['employee_id' => $idEmployee, 'day_number' => $day_number];

        return \DB::table('day_disponibilities')
            ->join('disponibilities', 'day_disponibilities.disponibility_id', '=', 'disponibilities.id')
            ->select(\DB::raw("disponibility_id, firstName, lastName, phone, date_format(startTime, '%H:%i') as startTime, date_format(endTime, '%H:%i') as endTime"))
            ->join('employees', 'disponibilities.employee_id', '=', 'employees.id')
            ->where($matches)
            ->orderBy('firstName', 'desc')
            ->get();
    }

    public static function DeleteDayDisponibilities($disponibilityId)
    {
        return \DB::table('day_disponibilities')
            ->where('disponibility_id', '=', $disponibilityId)
            ->delete();
    }
    //
}
