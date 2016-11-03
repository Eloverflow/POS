<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\Plan;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Punch;
use App\Models\POS\Separation;
use App\Models\POS\Table;
use App\Models\Project;
use App\Models\POS\TitleEmployee;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;

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

    /*For posio menu angilar app*/
    public function tablePlan($id)
    {
        $plan = Plan::where('id', $id)->first();
        $plan->load('table');
        $plan->load('separation');
        return $plan;
    }
    public function edit($id)
    {
        $plan = Plan::GetById($id);
        $tables =  Table::GetByPlanId($id);
        $separations =  Separation::where('plan_id', $id)->get();
        $view = \View::make('POS.Plan.edit')
            ->with('ViewBag', array (
                'plan' => $plan,
                'tables' => json_encode($tables),
                'separations' => json_encode($separations)
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
        $inputs = Input::all();


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
        else {

            $plan = Plan::where('id', $id)->first();

            $plan->update(['wallPoints' => Input::get('wallPoints')]);


            $jsonArray = json_decode(Input::get('tables'), true);

            for ($i = 0; $i < count($jsonArray); $i++) {

                $jsonArray[$i]["tblNumber"] = $jsonArray[$i]["tblNum"];
                $jsonArray[$i]["type"] = $jsonArray[$i]["tblType"];
                $jsonArray[$i]["plan_id"] = $id;


                if (!empty($jsonArray[$i]["id"])) {
                    $table = Table::where('id', $jsonArray[$i]["id"])->first();

                    if ($table != "") {
                        $table->update($jsonArray[$i]);
                    } else {
                        /*No table found at ID*/
                    }
                } else {
                    $table = Table::create($jsonArray[$i]);
                    if ($table == "") {
                        //Failed at creating table
                    }
                }

            }

            $jsonArraySep = json_decode(Input::get('separations'), true);

            $separations = Separation::where('plan_id', $id)->get();

            if (count($separations) > count($jsonArraySep)) {
                /*Removing deleted commands lines*/

                foreach ($separations as $separation) {
                    $isMissing = true;

                    foreach ($jsonArraySep as $inputSeparation) {
                        if ($separation['id'] == $inputSeparation['id'])
                            $isMissing = false;
                    }

                    if ($isMissing) {
                        $separation->delete();
                        /*Deleting a command line*/
                    }
                }
            }

            for ($i = 0; $i < count($jsonArraySep); $i++) {
                $jsonArraySep[$i]["plan_id"] = $id;

                if (!empty($jsonArraySep[$i]["id"])) {
                    $separation = Separation::where('id', $jsonArraySep[$i]["id"])->first();

                    if ($separation != "") {
                        $separation->update($jsonArraySep[$i]);
                    } else {
                        /*No table found at ID*/
                    }
                } else {
                    $separation = Separation::create($jsonArraySep[$i]);
                    if ($separation == "") {
                        //Failed at creating table
                    }
                }
            }


        }

        return \Response::json([
            'success' => "The plan " . Input::get('planName') . " has been successfully created !"
        ], 201);
    }



    public function postCreate()
    {
        $inputs = Input::all();

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
                'name' => Input::get('planName'),
                'nbFloor' => Input::get('nbFloor'),
                'wallPoints' => Input::get('wallPoints')
            ]);

            $jsonArray = json_decode(Input::get('tables'), true);
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

        $jsonArraySep = json_decode(Input::get('separations'), true);
        for ($i = 0; $i < count($jsonArraySep); $i++) {
            $jsonArraySep[$i]["plan_id"] = $plan->id;

                $separation = Separation::create($jsonArraySep[$i]);
                if ($separation == "") {
                    //Failed at creating table
                }
        }

            return \Response::json([
                'success' => "The plan " . Input::get('planName') . " has been successfully created !"
            ], 201);
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
