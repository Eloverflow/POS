<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public static function getById($id)
    {
        return \DB::table('employees')
            ->join('employee_titles', 'employees.employeeTitle', '=', 'employee_titles.id')
            ->join('users', 'employees.userId', '=', 'users.id')
            ->select(\DB::raw('employees.id as idEmployee, employees.salary, streetAddress, phone, firstName, lastName, employee_titles.name as employeeTitle, city, nas, pc, state, birthDate, hireDate, email, hireDate'))
            ->where('employees.id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('employees')
            ->join('employee_titles', 'employees.employeeTitle', '=', 'employee_titles.id')
            ->join('users', 'employees.userId', '=', 'users.id')
            ->select(\DB::raw('employees.id as idEmployee, firstName, lastName, employee_titles.name as name, email, hireDate'))
            ->get();
    }
}
