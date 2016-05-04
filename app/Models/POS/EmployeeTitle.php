<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class EmployeeTitle extends Model
{
    protected $table = 'employee_titles';
    protected $fillable = ['name', 'baseSalary' ];

    public static function getById($id)
    {
        return \DB::table('employee_titles')
            ->select(\DB::raw('employee_titles.*'))
            ->where('id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('employee_titles')
            ->select(\DB::raw('employee_titles.id as emplTitleId, name, baseSalary'))
            ->get();
    }

    public static function getEmployeesByTitleId($id)
    {
        return \DB::table('title_employees')
        ->join('employees', 'title_employees.employee_id', '=', 'employees.id')
        ->select(\DB::raw('employees.id as idEmployee, title_employees.id as idTitleEmployee, employees.bonusSalary, streetAddress, phone, firstName, lastName, city, nas, pc, state, birthDate, hireDate'))
        ->where('employee_titles_id', '=', $id)
        ->get();
    }

}
