<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class WorkTitle extends Model
{
    //use Searchable;
    protected $table = 'work_titles';
    protected $fillable = ['name', 'baseSalary' ];

    public static function getById($id)
    {
        return \DB::table('work_titles')
            ->select(\DB::raw('work_titles.*'))
            ->where('id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::table('work_titles')
            ->select(\DB::raw('work_titles.id as emplTitleId, name, baseSalary'))
            ->get();
    }

    public static function getEmployeesByTitleId($id)
    {
        return \DB::table('title_employees')
        ->join('employees', 'title_employees.employee_id', '=', 'employees.id')
        ->select(\DB::raw('employees.id as idEmployee, title_employees.id as idTitleEmployee, employees.bonusSalary, streetAddress, phone, firstName, lastName, city, nas, pc, state, birthDate, hireDate'))
        ->where('work_titles_id', '=', $id)
        ->get();
    }

}
