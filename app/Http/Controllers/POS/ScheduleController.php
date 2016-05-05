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

use App\Models\POS\Shared\CalendarEvent;
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
        $view = \View::make('POS.Schedule.index')->with('ViewBag', array(
            'schedules' => $schedules
        ));
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
        $schedule = Schedule::getById($scheduleid);
        $weekDispos = array(
            0 => Schedule::GetDaySchedulesForEmployee($scheduleid, 0, $employeeId),
            1 => Schedule::GetDaySchedulesForEmployee($scheduleid, 1, $employeeId),
            2 => Schedule::GetDaySchedulesForEmployee($scheduleid, 2, $employeeId),
            3 => Schedule::GetDaySchedulesForEmployee($scheduleid, 3, $employeeId),
            4 => Schedule::GetDaySchedulesForEmployee($scheduleid, 4, $employeeId),
            5 => Schedule::GetDaySchedulesForEmployee($scheduleid, 5, $employeeId),
            6 => Schedule::GetDaySchedulesForEmployee($scheduleid, 6, $employeeId),
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

                    $date = new DateTime($schedule->startDate);
                    $date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime. '-04:00');
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime. '-04:00');

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        $weekDispos[$i][$j]->firstName,
                        false, //full day event?
                        $dispoBegin, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                        $dispoEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                        $weekDispos[$i][$j]->id
                    );
                }
            }
        }

        $calendarSettings = array('left' => '',
            'center' => 'title',
            'right' => '');

        $strCalendar = "[Semaine du " . $schedule->startDate . " au " . $schedule->endDate . "]";


        $calendar = \Calendar::addEvents($events)->setOptions([
            'defaultDate' => $schedule->startDate,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'lang' => 'fr-ca',
            'titleFormat' => $strCalendar,
            'timezone' => 'local', 'EDT', ('America/Montreal')
        ]);

        return view('POS.Schedule.employee', compact('calendar'));
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
                        table
                        {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        table, th, td {
                           text-align: center;
                           border: 1px solid black;
                        }
                        table .dayCol {
                            width: 120px;
                        }
                        </style>
                        </head>
                        <body>" . Utils::getDaySchedulesHtml($schedule, $scheduleInfos) . "</body></html>");
        $pdf->setPaper('A4', 'landscape');
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
        $schedule = Schedule::GetById($id);

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

                    $date = new DateTime($schedule->startDate);
                    $date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime. '-4:00');
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime. '-04:00');

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        $weekDispos[$i][$j]->firstName,
                        false, //full day event?
                        $dispoBegin, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                        $dispoEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                        $weekDispos[$i][$j]->id
                    );
                }
            }
        }

        $strCalendar = "[Semaine du " . $schedule->startDate . " au " . $schedule->endDate . "]";

        $calendarSettings = array('left' => '',
            'center' => 'title',
            'right' => '');


        $calendar = \Calendar::addEvents($events)->setOptions([
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'defaultDate' => $schedule->startDate,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'lang' => 'fr-ca',
            'titleFormat' => $strCalendar
        ]);

        $view = \View::make('POS.Schedule.details')->with('ViewBag', array(
            'calendar' => $calendar,
            'schedule' => $schedule
        ));
        return $view;
    }

    public function edit($id)
    {
        //$events = [];

       // $schedule = Schedule::GetById($id);


        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $employees = Employee::getAll();

        $schedule = Schedule::GetById($id);

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
                    $employeeId = $weekDispos[$i][$j]->employee_id;

                    $date = new DateTime($schedule->startDate);
                    $startDatewithTMZ =  date_create($schedule->startDate, timezone_open('America/Montreal'));
                    $startOffset = date_offset_get($startDatewithTMZ);
                    $offsetInHourFormat = ($startOffset /60) /60;

                    $date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime . $offsetInHourFormat);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime . $offsetInHourFormat);

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        $weekDispos[$i][$j]->firstName,
                        false,
                        $dispoBegin,
                        $dispoEnd,
                        $weekDispos[$i][$j]->id,
                        [
                            'employeeId' => $employeeId
                        ]
                    );
                }
            }
        }

        $strCalendar = "[Semaine du " . $schedule->startDate . " au " . $schedule->endDate . "]";

        $calendarSettings = array('left' => '',
            'center' => 'title',
            'right' => '');

        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'defaultDate' => $schedule->startDate,
            'editable' => true,
            'header' => $calendarSettings,
            'defaultView' => 'agendaWeek',
            'titleFormat' => $strCalendar,
            'lang' => 'fr-ca'
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ scheduleClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Schedule.edit')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar,
                'startDate' => $lastSundayStr,
                'endDate' => $lastDay->format('Y-m-d'),
                'schedule' => $schedule
            )
        );
        return $view;
    }

    public function postEdit()
    {
        $inputs = \Input::all();
        $rules = array(
            'name' => 'required',
            'scheduleId' => 'required',
            'startDate' => 'required',
            'endDate' => 'required'
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


            Schedule::where('id',\Input::get('scheduleId'))
                ->update([
                    'startDate' => \Input::get('startDate'),
                    'endDate' => \Input::get('endDate'),
                    'name' => \Input::get('name')
                ]);

            Schedule::DeleteDaySchedules(\Input::get('scheduleId'));

            $jsonArray = json_decode(\Input::get('events'), true);
            for ($i = 0; $i < count($jsonArray); $i++) {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $resStart = $dateStart->format('H:i:s');
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $resStop = $dateStop->format('H:i:s');

                //$date = date("H:i:s", $jsonArray[$i]["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => \Input::get('scheduleId'),
                    'employee_id' => $jsonArray[$i]["employeeId"],
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

            }

            return \Response::json([
                'success' => "The Schedule " . \Input::get('name') . " has been successfully edited !"
            ], 201);
        }

    }

    public function create()
    {

        $events = [];

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $strCalendar = "[Semaine du " . $lastSundayStr . " au " . $lastDay->format('Y-m-d') . "]";

        $calendarSettings = array('left' => '',
            'center' => 'title',
            'right' => '');

        $employees = Employee::getAll();
        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => true,
            'header' => $calendarSettings,
            'defaultView' => 'agendaWeek',
            'titleFormat' => $strCalendar,
            'lang' => 'fr-ca'
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ scheduleClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Schedule.create')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar,
                'startDate' => $lastSundayStr,
                'endDate' => $lastDay->format('Y-m-d')
            )
        );
        return $view;
    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required'
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

            $schedule = Schedule::create([
                'name' => \Input::get('name'),
                'startDate' => \Input::get('startDate'),
                'endDate' => \Input::get('endDate')
            ]);

            $jsonArray = json_decode(\Input::get('events'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $resStart = $dateStart->format('H:i:s');
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $resStop = $dateStop->format('H:i:s');

                $employeeId = $jsonArray[$i]["employeeId"];

                //$date = date("H:i:s", $jsonArray[$i]["StartTime"]);
                Day_Schedules::create([
                    "schedule_id" => $schedule->id,
                    'employee_id' => $employeeId,
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

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
