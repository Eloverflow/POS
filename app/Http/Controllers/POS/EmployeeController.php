<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\WorkTitle;
use App\Models\POS\Punch;
use App\Models\Project;
use App\Models\POS\TitleEmployee;
use App\Models\Auth\User;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Input;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::getAll();
        $view = \View::make('POS.Employee.index')->with('employees', $employees);
        return $view;
    }

    public function track($id)
    {
        $employee = Employee::GetById($id);
        $punches  = Punch::GetByEmployeeId($id);
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.track')->with('ViewBag', array (
            "employee" => $employee,
            "punches" => $punches
        ));
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
        $employeeTitles = TitleEmployee::All();

        $employeeTitlesInUse = TitleEmployee::getByEmployeeId($id);
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.edit')->with('ViewBag', array(
            'employee' => $employee,
            'employeeTitles' => $employeeTitles,
            'employeeTitlesInUse' => $employeeTitlesInUse
        ));
        return $view;
    }

    public function postEdit()
    {
        $inputs = Input::all();

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
            if (Input::has('id')) {
                return \Redirect::action('POS\EmployeeController@edit', array(Input::get('idEmployee')))->withErrors($validation)
                    ->withInput();
            }
        }
        else
        {
            $employee = Employee::where('id', Input::get('idEmployee'))
                ->update([
                'firstName' => Input::get('firstName'),
                'lastName' => Input::get('lastName'),
                'streetAddress' => Input::get('streetAddress'),
                'phone' => Input::get('phone'),
                'city' => Input::get('city'),
                'state' => Input::get('state'),
                'pc' => Input::get('pc'),
                'nas' => Input::get('nas'),
                'userId' => Input::get('idUser'),
                'bonusSalary' => Input::get('bonusSalary'),
                'birthDate' => Input::get('birthDate'),
                'hireDate' => Input::get('hireDate')
            ]);

            // We delete so we can re-insert properly.
            TitleEmployee::DeleteByEmployeeId(Input::get('idEmployee'));

            $employeeTitlesInpt = Input::get('employeeTitles');
            for($i = 0; $i < count($employeeTitlesInpt); $i++){
                TitleEmployee::create([
                    'employee_id' => Input::get('idEmployee'),
                    'employee_titles_id' => $employeeTitlesInpt[$i]
                ]);
            }


            return \Redirect::action('POS\EmployeeController@index');
        }
    }

    public function create()
    {
        $workTitles = WorkTitle::All();
        $view = \View::make('POS.Employee.create')->with('workTitles', $workTitles);
        return $view;
    }

    public function postCreate()
    {
        $inputs = Input::all();

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
            if (Input::has('id')) {
                return \Redirect::action('POS\EmployeeController@create')->withErrors($validation)
                    ->withInput();
            }
        }
        else
        {
            $user = User::create([
                'name' => 'user_employee',
                'email' => Input::get('email'),
                'password' => Input::get('password')
            ]);

            $user->save();

            $employee = Employee::create([
                'firstName' => Input::get('firstName'),
                'lastName' => Input::get('lastName'),
                'streetAddress' => Input::get('streetAddress'),
                'phone' => Input::get('phone'),
                'city' => Input::get('city'),
                'state' => Input::get('state'),
                'pc' => Input::get('pc'),
                'nas' => Input::get('nas'),
                'userId' => $user->id,
                'bonusSalary' => Input::get('bonusSalary'),
                'birthDate' => Input::get('birthDate'),
                'hireDate' => Input::get('hireDate')
            ]);

            $employeeTitlesInpt = Input::get('employeeTitles');
            for($i = 0; $i < count($employeeTitlesInpt); $i++){
                TitleEmployee::create([
                    'employee_id' => $employee->id,
                    'employee_titles_id' => $employeeTitlesInpt[$i]
                ]);
            }
            return \Redirect::action('POS\EmployeeController@index')->withSuccess('The employee has been successfully created !');
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }


    public function authenticateEmployee($id)
    {
        $password = Input::get('password');

        $employee = Employee::whereId($id)->first();

        if($employee != ""){
            $employee->load('user');

            $hashCheck = Hash::check($password, $employee->user->password);
            $employee['hashCheck'] = $hashCheck;


            if($hashCheck)
            {
                /*Password match*/

                Auth::loginUsingId($id);

            }else {
                $employee['error'] = "Mauvais mot de passe";
            }
        }
        else{
            $employee['error'] = "Aucun employé trouvé avec cet ID";
        }

        return $employee;
    }
    


}
