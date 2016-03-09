<?php

namespace App\Http\Controllers\POS;

use App;
use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\Project;
use App\Helpers\Utils;
use App\Models\POS\Schedule;
use App\Models\POS\Day_Schedules;
use App\Models\POS\Disponibility;

use Barryvdh\DomPDF\PDF;
use DateInterval;
use DateTime;
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
        if($schedules[0]->idSchedule == null){
            unset($schedules);
            $schedules = array();
        }
        $view = \View::make('POS.Schedule.index')->with('ViewBag', array(
            'schedules' => $schedules
        ));;
        return $view;
    }

    public function track($id)
    {
        $schedule = Schedule::GetById($id);
        $scheduleInfos = Schedule::GetScheduleEmployees($id);
        $view = \View::make('POS.Schedule.track')->with('ViewBag', array(
            'schedule' => $schedule,
            'scheduleInfos' => $scheduleInfos
        ));
        return $view;
    }
    // Attention a employee et employees ci-dessous.
    // Employees sort plus la liste des employeee pour un schedule
    public function employeesSchedule($scheduleid)
    {
        $schedule = Schedule::GetById($scheduleid);
        $employees = Schedule::getAllScheduleEmployees($scheduleid);
        $view = \View::make('POS.Schedule.employees')->with('ViewBag', array(
                'schedule' => $schedule,
                'employees' => $employees
            )
        );
        return $view;
    }

    public function employeeSchedule($scheduleid, $employeeId)
    {
        $employee = Employee::GetById($employeeId);
        $schedule = Schedule::GetById($scheduleid);
        $view = \View::make('POS.Schedule.employee')->with('ViewBag', array(
                'schedule' => $schedule,
                'employee' => $employee,
                'Rows' => Utils::GenerateScheduleTableForEmployee($scheduleid, $employeeId)
            )
        );
        return $view;
    }

    public static function GetSchedulePDF($scheduleid)
    {
        $schedule = Schedule::GetById($scheduleid);
        $scheduleInfos = Schedule::GetScheduleEmployees($scheduleid);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML("<html>
                        <head>
                        <style>
                        h2, h4, h5 {
                            margin: 0px;
                        }
                        .emplTrackBlock
                        {
                            border-bottom: 1px solid #c4e3f3;
                            margin-top: 10px;
                            margin-left: 12px;
                        }
                        .trackBloc
                        {
                            margin-top: 10px;
                            background-color:rgba(192,192,192,0.3);;
                        }
                        </style>
                        </head>
                        <body>" .
            Utils::getDaySchedulesHtml($schedule, $scheduleInfos) . "</body></html>");
        return $pdf->stream();
    }

    public static function GetScheduleForEmployeePDF($scheduleid, $employeeId)
    {
        $pdf = App::make('dompdf.wrapper');
        $rows = Utils::GenerateScheduleTableForEmployee($scheduleid, $employeeId);
        $htmlstring = "<html>
                        <head>
                        <style>
                        table {
                          border-collapse: collapse;
                          width: 100%;
                        }

                        td, th {
                          border: 1px solid #999;
                          padding: 0.5rem;
                          text-align: left;
                        }
                        </style>
                        </head>
                        <body>
                        <table class=\"collapse\" >
                        <thead>
                        <tr>
                        <th></th>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th></tr></thead><tbody>";
        for($k = 0; $k < count($rows); $k++)
        {
            $htmlstring = $htmlstring . $rows[$k];
        }
        $htmlstring = $htmlstring . "</tbody></table></body></html>";

        $pdf->loadHTML($htmlstring);
        return $pdf->stream();
    }

    public function details($id)
    {
        /*$schedule = Schedule::GetById($id);

        $view = \View::make('POS.Schedule.details')->with('ViewBag', array(
                'schedule' => $schedule,
                'Rows' => Utils::GenerateScheduleTable($id)
            )
        );
        return $view;*/

        $weekDispos = array(
            0 => Schedule::GetDaySchedules($id, 0),
            1 => Schedule::GetDaySchedules($id, 1),
            2 => Schedule::GetDaySchedules($id, 2),
            3 => Schedule::GetDaySchedules($id, 3),
            4 => Schedule::GetDaySchedules($id, 4),
            5 => Schedule::GetDaySchedules($id, 5),
            6 => Schedule::GetDaySchedules($id, 6),
        );



        $events = [];

        /*For each day of disponibility*/
        for($i = 0; $i < count($weekDispos); $i++) {


            /*If there are disponibility today */
            if (count($weekDispos[$i])) {


                /*For each disponibility*/
                for ($j = 0; $j < count($weekDispos[$i]); $j++) {
                    $startTime = $weekDispos[$i][$j]->startTime;
                    $endTime = $weekDispos[$i][$j]->endTime;



                    $date = new DateTime(Schedule::all()->first()->startDate);
                    $date->add(new DateInterval('P' . $i .'D'));

/*
                    $currentDay = date('Y-m-d', strtotime('+' . $i . ' day', Schedule::all()->first()->startDate));*/


                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime);

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        $weekDispos[$i][$j]->firstName . " - " . $startTime . " to " . $endTime, //event title
                        false, //full day event?
                        $dispoBegin, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                        $dispoEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                        1, //optional event ID
                        [
                            'url' => 'http://pos.mirageflow.com',
                            //any other full-calendar supported parameters
                        ]
                    );
                }
            }
        }

        $calendar = \Calendar::addEvents($events);

        return view('calendar', compact('calendar'));
    }

    public function edit($id)
    {
        $schedule = Schedule::GetById($id);
        $employeeTitles = EmployeeTitle::All();
        $employees = Employee::getAll();

        $WeekDisponibilities = array(
            0 => Schedule::GetDaySchedules($id, 0),
            1 => Schedule::GetDaySchedules($id, 1),
            2 => Schedule::GetDaySchedules($id, 2),
            3 => Schedule::GetDaySchedules($id, 3),
            4 => Schedule::GetDaySchedules($id, 4),
            5 => Schedule::GetDaySchedules($id, 5),
            6 => Schedule::GetDaySchedules($id, 6),
        );


        //DB::table('users')->get();
        $view = \View::make('POS.Schedule.edit')->with('ViewBag', array(
            'schedule' => $schedule,
            'weekSchedules' => $WeekDisponibilities,
            'employees' => $employees
        ));
        return $view;
    }

    public function postEdit()
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
            return \Redirect::action('POS\ScheduleController@edit')->withErrors($validation)
                ->withInput();

        }
        else
        {

            $idSchedule = \Input::get('idSchedule');

            // On commence par supprimer tous les jour de disponiblite associer a une disponibilite.
            Schedule::DeleteDaySchedules($idSchedule);

            Schedule::where('id', $idSchedule)
                ->update([
                    'name' => \Input::get('name'),
                    'startDate' => \Input::get('startDate'),
                    'endDate' => \Input::get('endDate'),
                ]);

            for($i = 0; $i < count(\Input::get('sunDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('sunDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
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
                    "schedule_id" => $idSchedule,
                    "employee_id" => $jsonObj["EmployeeId"],
                    "day_number" => 6,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            return \Redirect::action('POS\ScheduleController@index')->withSuccess('The schedule has been successfully edited !');
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

    public function AjaxGetEmployeeDaySchedules()
    {
        $scheduleId = \Input::get('scheduleId');
        $dayNumber = \Input::get('dayNumber');
        $hour = \Input::get('hour');

        $daySchedule = Schedule::GetDaySchedulesHour($scheduleId, $dayNumber, $hour);

        return response()->json(json_encode($daySchedule));
    }

}
