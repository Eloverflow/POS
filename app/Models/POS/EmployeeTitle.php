<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class EmployeeTitle extends Model
{
    protected $table = 'employee_titles';
    protected $fillable = ['name', 'baseSalary' ];

    public static function getById($id)
    {
        return \DB::table('employees')
            ->join('users', 'employees.userId', '=', 'users.id')
            ->select(\DB::raw('employees.id as idEmployee, users.id as idUser, employees.bonusSalary, streetAddress, phone, firstName, lastName, city, nas, pc, state, birthDate, hireDate, email, hireDate'))
            ->where('employees.id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('employee_titles')
            ->select(\DB::raw('id, name, baseSalary'))
            ->get();
    }
}
