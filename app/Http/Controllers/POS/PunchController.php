<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Punch;
use App\Models\POS\WorkTitle;
use App\Models\Project;
use App\Models\Auth\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;

class PunchController extends Controller
{
    public function index()
    {
        $view = \View::make('POS.Punch.main');
        return $view;
    }


    public function keyboard()
    {
        $view = \View::make('POS.Punch.vKeyboard');
        return $view;
    }

    public function tables()
    {
        $view = \View::make('POS.Punch.tablesSelect');
        return $view;
    }

    public function details($id)
    {
        $employee = Employee::GetById($id);
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.details')->with('employee', $employee);
        return $view;
    }

    public function edit($id)
    {
        $employee = Employee::GetById($id);
        $employeeTitles = EmployeeTitle::All();
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.edit')->with('ViewBag', array(
            'employee' => $employee,
            'employeeTitles' => $employeeTitles
        ));
        return $view;
    }

    public function postEdit()
    {
        $inputs = Input::all();

        $rules = array(
            'startTime' => 'required',
            'endTime' => 'required',
            'idPunch' => 'required',
            'idWorkTitle' => 'required',
            'idEmployee' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return \Response::json($validation->messages(), 400);
        }
        else
        {
            Punch::where('id', Input::get('idPunch'))
                ->update([
                'startTime' => Input::get('startTime'),
                'endTime' => Input::get('endTime'),
                'work_title_id' => Input::get('idWorkTitle'),
                'employee_id' => Input::get('idEmployee')

            ]);

            return \Response::json("The punch has been successfully edited !", 200);
        }
    }

    public function create()
    {
        $employeeTitles = EmployeeTitle::All();
        $view = \View::make('POS.Employee.create')->with('employeeTitles', $employeeTitles);
        return $view;
    }

    public function postCreate()
    {
        $inputs = Input::all();

        $rules = array(
            'startTime' => 'required',
            'endTime' => 'required',
            'idPunch' => 'required',
            'idWorkTitle' => 'required',
            'idEmployee' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return \Response::json($validation->messages(), 400);
        }
        else
        {
                Punch::create([
                    'startTime' => Input::get('startTime'),
                    'endTime' => Input::get('endTime'),
                    'work_title_id' => Input::get('idWorkTitle'),
                    'employee_id' => Input::get('idEmployee')
                ]);

            return \Response::json("The punch has been successfully created !", 200);
        }
    }

    public function postDelete($id)
    {
        Punch::where('id', $id)
            ->delete();
        return \Response::json("The punch has been successfully deleted !", 200);
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }

    public function ajaxPunchEmployee()
    {
        $employeeId =  Input::get('EmployeeNumber');
        $workTitleId =  Input::get('WorkTitleId');

        $validEmplId = 100 - $employeeId;
        //$employee = Punch::GetLatestPunch($employeeId);
        $employeePunch = Punch::where('employee_id', $employeeId)->get()->last();
        //var_dump($employeePunch);


        $employee = Employee::whereId($employeeId)->first();

        if(!empty($employee))
        Auth::loginUsingId($employee['userId']);

        if (!empty($employeePunch)) {
            if($employeePunch->endTime == 0){

                $employeePunch->update(['endTime' => date("Y-m-d H:i:s")]);

                return response()->json(['status' => 'Success',
                    'message' =>  'The employee has been successfully punched out !'
                ]);
            }
            else {

                if(empty($workTitleId)){
                    return response()->json(['status' => 'Error',
                        'message' =>  'The employee punch was closed. Give a work title for the new punch',
                        'requireWorkTitle' =>  true
                    ]);
                }
                else{

                    $unauthorized = true;
                    $employees = WorkTitle::getEmployeesByTitleId($workTitleId);

                  /*  return response()->json(['status' => 'Error',
                        'message' =>  'The employee punch was closed. Give a work title for the new punch',
                        '$employees' =>  $employees,
                        '$employeeId' =>  (int)$employeeId
                    ]);*/
                    foreach($employees as $currentEmployee){
                        if(!empty($currentEmployee) && $currentEmployee->idEmployee == (int)$employeeId){
                            $unauthorized = false;
                        }
                    }

                    Punch::create(['work_title_id' => $workTitleId, 'startTime' => date("Y-m-d H:i:s"), 'employee_id' => $employeeId, 'unauthorized' => $unauthorized]);
                    return response()->json(['status' => 'Success',
                        'message' =>  'The employee has been successfully punched in !'
                    ]);
                }
            }

        }
        else{
            if(is_null(Employee::getById($employeeId)) == false){
                if(empty($workTitleId)){
                    return response()->json(['status' => 'Error',
                        'message' =>  'No employee punch were found. Give a work title for the new punch',
                        'requireWorkTitle' =>  true
                    ]);
                }
                else{
                    $unauthorized = true;
                    $employees = WorkTitle::getEmployeesByTitleId($workTitleId);

                    foreach($employees as $currentEmployee){
                        if(!empty($currentEmployee) && $currentEmployee->idEmployee == (int)$employeeId){
                            $unauthorized = false;
                        }
                    }

                    Punch::create(['work_title_id' => $workTitleId, 'startTime' => date("Y-m-d H:i:s"), 'employee_id' => $employeeId, 'unauthorized' => $unauthorized]);
                    return response()->json(['status' => 'Success',
                        'message' =>  'The employee has been successfully punched in !'
                    ]);
                }
            }
            else {
                return response()->json(['status' => 'Error',
                    'message' =>  'This employee doesnt exist !']);
            }
        }

    }

}
