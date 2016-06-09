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


    public function employeeSchedule($scheduleid, $employeeId)
    {
        $schedule = Schedule::GetById($scheduleid);

        $daySchedulesEMpl = Schedule::GetScheduleMomentsForEmployee($scheduleid, $employeeId);

        $usedColors = [];

        $events = [];

        for($i = 0; $i < count($daySchedulesEMpl); $i++){

            $startDatewithTMZ =  date_create($daySchedulesEMpl[$i]->startTime, timezone_open('America/Montreal'));
            $startOffset = date_offset_get($startDatewithTMZ);
            $offsetInHourFormat = ($startOffset /60) /60;

            $availableColor = "";
            $employeeColor = $this->GetEmployeeColor($usedColors,$daySchedulesEMpl[$i]->idEmployee);
            if($employeeColor == ""){
                $availableColors = $this->GetAvailableColors($usedColors);
                $availableColor = $availableColors[0];
                $usedColors[] = array("idEmployee" => $daySchedulesEMpl[$i]->idEmployee, "color" => $availableColor);
            } else {
                $availableColor = $employeeColor;
            }

            $momentStart = new DateTime($daySchedulesEMpl[$i]->startTime . $offsetInHourFormat);
            $momentEnd = new DateTime($daySchedulesEMpl[$i]->endTime . $offsetInHourFormat);

            $events[] = \Calendar::event(
                $daySchedulesEMpl[$i]->firstName . " " . $daySchedulesEMpl[$i]->lastName,
                false, //full day event?
                $momentStart, //start time, must be a ateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $momentEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $daySchedulesEMpl[$i]->id,
                [
                    'color' => $availableColor
                ]
            );

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

        $daySchedules = Schedule::GetScheduleMoments($id);

        $usedColors = [];

        $events = [];

        for($i = 0; $i < count($daySchedules); $i++){

            $startDatewithTMZ =  date_create($daySchedules[$i]->startTime, timezone_open('America/Montreal'));
            $startOffset = date_offset_get($startDatewithTMZ);
            $offsetInHourFormat = ($startOffset /60) /60;

            $availableColor = "";
            $employeeColor = $this->GetEmployeeColor($usedColors,$daySchedules[$i]->idEmployee);
            if($employeeColor == ""){
                $availableColors = $this->GetAvailableColors($usedColors);
                $availableColor = $availableColors[0];
                $usedColors[] = array("idEmployee" => $daySchedules[$i]->idEmployee, "color" => $availableColor);
            } else {
                $availableColor = $employeeColor;
            }

            $momentStart = new DateTime($daySchedules[$i]->startTime . $offsetInHourFormat);
            $momentEnd = new DateTime($daySchedules[$i]->endTime . $offsetInHourFormat);

            $events[] = \Calendar::event(
                $daySchedules[$i]->firstName . " " . $daySchedules[$i]->lastName,
                false, //full day event?
                $momentStart, //start time, must be a ateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $momentEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $daySchedules[$i]->id,
                [
                    'color' => $availableColor
                ]
            );

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

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $employees = Employee::getAll();

        $schedule = Schedule::GetById($id);

        $daySchedules = Schedule::GetScheduleMoments($id);

        $usedColors = [];

        $events = [];

        for($i = 0; $i < count($daySchedules); $i++){

            $startDatewithTMZ =  date_create($daySchedules[$i]->startTime, timezone_open('America/Montreal'));
            $startOffset = date_offset_get($startDatewithTMZ);
            $offsetInHourFormat = ($startOffset /60) /60;

            $availableColor = "";
            $employeeColor = $this->GetEmployeeColor($usedColors,$daySchedules[$i]->idEmployee);
            if($employeeColor == ""){
                $availableColors = $this->GetAvailableColors($usedColors);
                $availableColor = $availableColors[0];
                $usedColors[] = array("idEmployee" => $daySchedules[$i]->idEmployee, "color" => $availableColor);
            } else {
                $availableColor = $employeeColor;
            }

            $momentStart = new DateTime($daySchedules[$i]->startTime . $offsetInHourFormat);
            $momentEnd = new DateTime($daySchedules[$i]->endTime . $offsetInHourFormat);

            $events[] = \Calendar::event(
                $daySchedules[$i]->firstName . " " . $daySchedules[$i]->lastName,
                false, //full day event?
                $momentStart, //start time, must be a ateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $momentEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $daySchedules[$i]->id,
                [
                    'color' => $availableColor,
                    'employeeId' => $daySchedules[$i]->idEmployee
                ]
            );

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
                    /*'startDate' => \Input::get('startDate'),
                    'endDate' => \Input::get('endDate'),*/
                    'name' => \Input::get('name')
                ]);

            Schedule::DeleteDaySchedules(\Input::get('scheduleId'));

            $jsonArray = json_decode(\Input::get('events'), true);
            for ($i = 0; $i < count($jsonArray); $i++) {

                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);

                Day_Schedules::create([
                    "schedule_id" => \Input::get('scheduleId'),
                    'employee_id' => $jsonArray[$i]["employeeId"],
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $dateStart,
                    "endTime" => $dateStop
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
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $employeeId = $jsonArray[$i]["employeeId"];

                Day_Schedules::create([
                    "schedule_id" => $schedule->id,
                    'employee_id' => $employeeId,
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $dateStart,
                    "endTime" => $dateStop
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

    public function GetEmployeeColor($usedColors, $idEmployee)
    {
        $emplColor = "";
        foreach($usedColors  as $usedColor){
            if($usedColor["idEmployee"] == $idEmployee){
                $emplColor = $usedColor["color"];
            }
        }

        return $emplColor;
    }

    public function GetAvailableColors($usedColors)
    {
        $availableColors = array();
        $niceColors = array(
            0 => "#6AA4C1",
            1 => "#800000",
            2 => "#520043",
            3 => "#33044D",
            4 => "#1A094F",
            5 => "#0C0C50",
            6 => "#00502A",
            7 => "#256500",
            8 => "#737300"
        );

        if(count($usedColors) == 0){
            $availableColors[] = $niceColors[0];
        } else {
            for($i = 0; $i < count($niceColors); $i++){

                $colorFound = false;
                foreach($usedColors  as $usedColor){
                    if($niceColors[$i] == $usedColor["color"]){
                        $colorFound = true;
                    }
                }

                if(!$colorFound){
                    $availableColors[] = $niceColors[$i];
                }
            }

            if(count($availableColors) == 0){
                $availableColors[] = $niceColors[0];
            }
        }

        return $availableColors;
    }
}
