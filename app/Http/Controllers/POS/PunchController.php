<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Punch;
use App\Models\Project;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PunchController extends Controller
{
    public function index()
    {
        $view = \View::make('POS.Punch.main');
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
        $inputs = \Input::all();

        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            if (\Input::has('id')) {
                return \Redirect::action('POS\EmployeeController@edit', array(\Input::get('idEmployee')))->withErrors($validation)
                    ->withInput();
            }
        }
        else
        {
            $employee = Employee::where('id', \Input::get('idEmployee'))
                ->update([
                'firstName' => \Input::get('firstName'),
                'lastName' => \Input::get('lastName'),
                'streetAddress' => \Input::get('streetAddress'),
                'phone' => \Input::get('phone'),
                'city' => \Input::get('city'),
                'state' => \Input::get('state'),
                'pc' => \Input::get('pc'),
                'nas' => \Input::get('nas'),
                'employeeTitle' => \Input::get('employeeTitle'),
                'userId' => \Input::get('idUser'),
                'salary' => \Input::get('salary'),
                'birthDate' => \Input::get('birthDate'),
                'hireDate' => \Input::get('hireDate')
            ]);

            return \Redirect::action('POS\EmployeeController@index');
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
        $inputs = \Input::all();

        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            if (\Input::has('id')) {
                return \Redirect::action('POS\EmployeeController@create')->withErrors($validation)
                    ->withInput();
            }
        }
        else
        {
            $user = User::create([
                'name' => 'default_username',
                'email' => \Input::get('email'),
                'password' => bcrypt(\Input::get('password')),

            ]);
            $employee = Employee::create([
                'firstName' => \Input::get('firstName'),
                'lastName' => \Input::get('lastName'),
                'streetAddress' => \Input::get('streetAddress'),
                'phone' => \Input::get('phone'),
                'city' => \Input::get('city'),
                'state' => \Input::get('state'),
                'pc' => \Input::get('pc'),
                'nas' => \Input::get('nas'),
                'employeeTitle' => \Input::get('employeeTitle'),
                'userId' => $user->id,
                'salary' => \Input::get('salary'),
                'birthDate' => \Input::get('birthDate'),
                'hireDate' => \Input::get('hireDate')
            ]);

            return \Redirect::action('POS\EmployeeController@index')->withSuccess('The employee has been successfully created !');
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }

    public function ajaxPunchEmployee()
    {
        $employeeId =  \Input::get('EmployeeNumber');

        $validEmplId = 100 - $employeeId;
        $employee = Punch::GetLatestPunch($employeeId);
        //var_dump($employee);

        if (count($employee)) {
            if($employee->inout == "in"){
                Punch::create(['inout' => 'out', 'employee_id' => $employeeId]);
                return response()->json(['status' => 'Success',
                    'message' =>  'The employee has been successfully punched out !'
                ]);
            }
            else if($employee->inout == "out") {
                Punch::create(['inout' => 'in', 'employee_id' => $employeeId]);
                return response()->json(['status' => 'Success',
                    'message' =>  'The employee has been successfully punched in !'
                ]);
            }

        }
        else{
            if(is_null(Employee::getById($employeeId)) == false){
                Punch::create(['inout' => 'in', 'employee_id' => $employeeId]);
                return response()->json(['status' => 'Success',
                    'message' =>  'The employee has been successfully punched in !'
                ]);
            }
            else {
                return response()->json(['status' => 'Error',
                    'message' =>  'This employee doesnt exist !']);
            }
        }

    }

}
