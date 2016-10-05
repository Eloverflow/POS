<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class TitleEmployee extends Model
{

    //
    protected $table = 'title_employees';
    protected $fillable = ['employee_id', 'work_titles_id'];

    public static function getByEmployeeId($employeeId)
    {
        return \DB::table('title_employees')
            ->join('work_titles', 'title_employees.work_titles_id', '=', 'work_titles.id')
            ->select(\DB::raw('title_employees.id as idTitleEmployees,
            work_titles.id as idEmployeeTitles,
            work_titles.name,
            work_titles.baseSalary
            '))
            ->where('title_employees.employee_id', '=', $employeeId)
            ->get();
    }

    public static function getByEmployeeAndTitleId($employeeId, $employeeTitleId)
    {
        return \DB::table('title_employees')
            ->join('work_titles', 'title_employees.work_titles_id', '=', 'work_titles.id')
            ->select(\DB::raw('title_employees.id as idTitleEmployees,
            work_titles.id as idEmployeeTitles,
            work_titles.name,
            work_titles.baseSalary
            '))
            ->where('title_employees.employee_id', '=', $employeeId)
            ->where('title_employees.work_titles_id', '=', $employeeTitleId)
            ->first();
    }

    public static function DeleteByEmployeeId($employeeId)
    {
        return \DB::table('title_employees')
            ->where('employee_id', '=', $employeeId)
            ->delete();
    }

}
