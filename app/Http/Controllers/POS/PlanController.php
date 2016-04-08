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

class PlanController extends Controller
{
    public function index()
    {
        $plans = EmployeeTitle::getAll();
        $view = \View::make('POS.Plan.index')
            ->with('ViewBag', array (

            ));
        return $view;
    }

    public function create($planName, $nbFloor)
    {
        $view = \View::make('POS.Plan.create')
            ->with('ViewBag', array (
                'planName' => $planName,
                'nbFloor' => $nbFloor
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
