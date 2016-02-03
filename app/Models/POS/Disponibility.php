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
        return \DB::table('disponibilities')
            ->join('employees', 'disponibilities.employee_id', '=', 'employees.id')
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
            ->where($matches)
            ->get();
    }

    public static function GetDayDisponibilitiesForEmployee($day_number, $idEmployee)
    {
        $matches = ['disponibility_id' => $id, 'day_number' => $day_number];
        return \DB::table('day_disponibilities')
            ->where($matches)
            ->get();
    }
    //
}
