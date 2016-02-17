<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\Project;
use App\Models\POS\Schedule;
use App\Models\POS\Day_Schedules;
use App\Models\POS\Disponibility;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::GetAll();
        $view = \View::make('POS.Schedule.index')->with('ViewBag', array(
            'schedules' => $schedules
        ));;
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
        $employees = Employee::getAll();
        $view = \View::make('POS.Schedule.create')->with('ViewBag', array(
            'employees' => $employees
        ));
        return $view;
    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'name' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return \Redirect::action('POS\ScheduleController@create')->withErrors($validation)
                ->withInput();

        }
        else
        {

            $Schedule = Schedule::create([
                'name' => \Input::get('name'),
                'startDate' => \Input::get('startDate'),
                'endDate' => \Input::get('endDate')
            ]);

            for($i = 0; $i < count(\Input::get('sunDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('sunDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 0,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('monDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('monDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 1,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('tueDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('tueDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 2,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('wedDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('wedDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 3,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('thuDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('thuDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 4,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('friDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('friDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 5,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('satDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('satDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $Schedule->id,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 6,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            return \Redirect::action('POS\ScheduleController@index')->withSuccess('The schedule has been successfully created !');
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }

    public function AjaxFindDispos()
    {

        $dayNumber = \Input::get('dayNumber');
        $idEmployee = \Input::get('idEmployee');

        if($idEmployee != -2) // -2 represente le "Select" de la Select Option
        {
            if($idEmployee == -1) // -1 represente le "All" de la Select Option
            {
                $disponibilities = Disponibility::GetDayDisponibilitiesForAll($dayNumber);

            }
            else
            {
                // Evidemment, un employee a ete selectionne
                $disponibilities = Disponibility::GetDayDisponibilitiesForEmployee($dayNumber, $idEmployee);
            }
        }

        return response()->json(json_encode($disponibilities));
    }

}
