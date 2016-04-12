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
                'planName' => \Input::get('planName'),
                'nbFloor' => \Input::get('nbFloor')
            ]);

            $jsonArray = json_decode(\Input::get('floors'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $tables = $jsonArray[$i]["tables"];
                for($j = 0; $j < count($tables); $j++) {
                    tables::create([
                        "schedule_id" => $schedule->id,
                        'employee_id' => $employeeId,
                        "day_number" => $jsonArray[$i]["dayIndex"],
                        "startTime" => $resStart,
                        "endTime" => $resStop
                    ]);
                }

            }

            return \Response::json([
                'success' => "The Schedule " . \Input::get('name') . " has been successfully created !"
            ], 201);
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
