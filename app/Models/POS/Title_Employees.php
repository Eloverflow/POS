<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Title_Employees extends Model
{
    //
    protected $table = 'title_employees';
    protected $fillable = ['employee_id', 'employee_titles_id'];

    public static function getByEmployeeId($employeeId)
    {
        return \DB::table('title_employees')
            ->join('employee_titles', 'title_employees.employee_titles_id', '=', 'employee_titles.id')
            ->select(\DB::raw('title_employees.id as idTitleEmployees,
            employee_titles.id as idEmployeeTitles,
            employee_titles.name,
            employee_titles.baseSalary
            '))
            ->where('title_employees.employee_id', '=', $employeeId)
            ->get();
    }

    public static function DeleteByEmployeeId($employeeId)
    {
        return \DB::table('title_employees')
            ->where('employee_id', '=', $employeeId)
            ->delete();
    }

}
