<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\Plan;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Punch;
use App\Models\POS\Table;
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

        $plans2 = Plan::all();
        $plans2->load('table');

        $plans = Plan::getAll();
        $view = \View::make('POS.Plan.index')
            ->with('ViewBag', array (
                'plans' => $plans2
            ));
        return $view;
    }

    public function tablePlan($id)
    {
        $plan = Plan::where('id', $id)->first();
        $plan->load('table');
        return $plan;
    }
    public function edit($id)
    {
        $plan = Plan::GetById($id);
        $tables =  Table::GetByPlanId($id);
        $view = \View::make('POS.Plan.edit')
            ->with('ViewBag', array (
                'plan' => $plan,
                'tables' => json_encode($tables)
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

    public function postEdit($id)
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
            $jsonArray = json_decode(\Input::get('tables'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {

                $jsonArray[$i]["tblNumber"] = $jsonArray[$i]["tblNum"];
                $jsonArray[$i]["type"] = $jsonArray[$i]["tblType"];
                $jsonArray[$i]["plan_id"] = $id;


                if(!empty($jsonArray[$i]["id"]))
                {
                    $table = Table::where('id', $jsonArray[$i]["id"])->first();

                    if($table != ""){
                        $table->update($jsonArray[$i]);
                    }else{
                        /*No table found at ID*/
                    }
                }
                else
                {
                    $table = Table::create($jsonArray[$i]);
                    if($table == "") {
                        //Failed at creating table
                    }
                }

            }

        }

        return \Response::json([
            'success' => "The plan " . \Input::get('planName') . " has been successfully created !"
        ], 201);
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

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
