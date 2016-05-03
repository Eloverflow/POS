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
    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'planName' => 'required',
            'nbFloor' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {

            $plan = Plan::create([
                'name' => \Input::get('planName'),
                'nbFloor' => \Input::get('nbFloor')
            ]);

            $jsonArray = json_decode(\Input::get('tables'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {
                Table::create([
                    "type" => $jsonArray[$i]["tblType"],
                    "tblNumber" => $jsonArray[$i]["tblNum"],
                    "noFloor" => $jsonArray[$i]["noFloor"],
                    'xPos' => $jsonArray[$i]["xPos"],
                    "yPos" => $jsonArray[$i]["yPos"],
                    "angle" => $jsonArray[$i]["angle"],
                    "plan_id" => $plan->id,
                    "status" => 1
                ]);
            }

        }

        return \Response::json([
            'success' => "The plan " . \Input::get('planName') . " has been successfully created !"
        ], 201);
    }

    public function postEdit()
    {
        $inputs = \Input::all();

        $rules = array(
            'emplTitleId' => 'required',
            'emplTitleName' => 'required',
            'emplTitleBaseSalary' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);
        }
        else
        {

            EmployeeTitle::where('id', \Input::get('emplTitleId'))
            ->update([
                'name' => \Input::get('emplTitleName'),
                'baseSalary' => \Input::get('emplTitleBaseSalary')
            ]);

        }

        return \Response::json([
            'success' => "The Employee Title " . \Input::get('planName') . " has been successfully created !"
        ], 201);
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
