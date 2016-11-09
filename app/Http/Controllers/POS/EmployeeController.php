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

        $workTitle = WorkTitle::all();
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.track')->with('ViewBag', array (
            "employee" => $employee,
            "punches" => $punches,
            "work_titles" => $workTitle
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
        $employeeTitles = WorkTitle::All();

        $employeeTitlesInUse = TitleEmployee::getByEmployeeId($id);
        //DB::table('users')->get();
        $view = \View::make('POS.Employee.edit')->with('ViewBag', array(
            'employee' => $employee,
            'employeeTitles' => $employeeTitles,
            'employeeTitlesInUse' => $employeeTitlesInUse
        ));
        return $view;
    }

    public function postEdit($id)
    {
        $inputs = Input::all();

        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required',
            'nas' => ['required', 'regex:/^(\d{3}-\d{3}-\d{3})|(\d{3} \d{3} \d{3})|(\d{9})$/'],
            'phone' => ['required', 'regex:/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/'] ,
            'pc' => ['regex:/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/'],
            'bonusSalary' => ['regex:/^\d*\.?\d*$/'],
            'hireDate' => ['required', 'date_multi_format:"Y-m-d"'  ], //'date_multi_format:"Y-m-d H:i:s.u","Y-m-d"'
            'birthDate' => ['date_multi_format:"Y-m-d"'],
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);


        $validation->after(function($validator) {
            if (!$this->ValidateSelectedWorkTitles(Input::get('employeeTitles'))) {
                $validator->errors()->add('employeeTitles', 'At least one of the work title should be selected !');
            }
        });


        if($validation->fails())
        {

            return \Redirect::action('POS\EmployeeController@edit')->withErrors($validation)
                ->withInput();

        }
        else
        {

            $employee = Employee::where('id', $id)
                ->update(['firstName' => Input::get('firstName'),
                'lastName' => Input::get('lastName'),
                'streetAddress' => Input::get('streetAddress'),
                'phone' => Input::get('phone'),
                'city' => Input::get('city'),
                'state' => Input::get('state'),
                'pc' => Input::get('pc'),
                'nas' => Input::get('nas'),
                'bonusSalary' => Input::get('bonusSalary'),
                'birthDate' => Input::get('birthDate'),
                'hireDate' => Input::get('hireDate')
            ]);

            // We delete so we can re-insert properly.
            TitleEmployee::DeleteByEmployeeId($id);

            $employeeTitlesInpt = Input::get('employeeTitles');
            for($i = 0; $i < count($employeeTitlesInpt); $i++){
                TitleEmployee::create([
                    'employee_id' => $id,
                    'work_titles_id' => $employeeTitlesInpt[$i]
                ]);
            }
            return \Redirect::action('POS\EmployeeController@index')->withSuccess('The employee has been successfully edited !');
        }
    }

    public function create()
    {
        $workTitles = WorkTitle::All();
        $view = \View::make('POS.Employee.create')
            ->with('ViewBag', array (
                'WorkTitles' => $workTitles
            ));
        return $view;
    }

    public function postCreate()
    {
        $inputs = Input::all();

        $rules = array(
            'email'=> ['required', 'email'], //'regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/'
            'firstName' => 'required',
            'lastName' => 'required',
            'nas' => ['required', 'regex:/^(\d{3}-\d{3}-\d{3})|(\d{3} \d{3} \d{3})|(\d{9})$/'],
            'phone' => ['required', 'regex:/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/'] ,
            'pc' => ['regex:/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/'],
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'bonusSalary' => ['regex:/^\d*\.?\d*$/'],
            'hireDate' => ['required', 'date_multi_format:"Y-m-d"'  ], //'date_multi_format:"Y-m-d H:i:s.u","Y-m-d"'
            'birthDate' => ['date_multi_format:"Y-m-d"'],
            /*'employeeTitles[]' => ['select_multiple_number:1']*/
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);


        // Faire une regle unique (A voir) pour conserver la priorité des validation
        $validation->after(function($validator) {
            if (!$this->ValidateSelectedWorkTitles(Input::get('employeeTitles'))) {
                $validator->errors()->add('employeeTitles', 'At least one of the work title should be selected !');
            }
        });

        $validation->after(function($validator) {
            $user = User::where('email', '=', Input::get('email'))->first();
            if ($user != null) {
                $validator->errors()->add('email', 'This email is already in use !');
            }
        });

        if($validation->fails())
        {

            return \Redirect::action('POS\EmployeeController@create')->withErrors($validation)
                ->withInput();

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
                    'work_titles_id' => $employeeTitlesInpt[$i]
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
            $employee['ecnrypted'] = $employee->user->password;
            $employee['pass'] = $password;


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


    function ValidateSelectedWorkTitles($value) {
        $min = 1;
        return count($value) >= $min;
    }


}
