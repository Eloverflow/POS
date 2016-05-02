<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Punch;
use App\Models\Project;
use App\Models\POS\Title_Employees;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeTitleController extends Controller
{
    public function index()
    {
        $employeeTitles = EmployeeTitle::getAll();

        for($i = 0; $i < count($employeeTitles); $i++){
            $employees = EmployeeTitle::getEmployeesByTitleId($employeeTitles[$i]->id);
            $employeeTitles[$i]->{"cntEmployees"} = $employees;
        }

        $view = \View::make('POS.EmployeeTitle.index')
            ->with('ViewBag', array (
                'employeeTitles' => $employeeTitles
            ));
        return $view;
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
