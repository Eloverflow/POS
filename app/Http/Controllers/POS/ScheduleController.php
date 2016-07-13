<?php

namespace App\Http\Controllers\POS;

use App;
use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\Project;
use App\Helpers\Utils;
use App\Models\POS\Schedule;
use App\Models\POS\Punch;
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


    private function SortEmployeePunches($employeeId, $punches){
        $sortedPunchesArray = array();
        for($k = 0; $k < count($punches); $k++) {

            if ($punches[$k]->idEmployee == $employeeId) {

                array_push($sortedPunchesArray, $punches[$k]);

            }
        }
        return $sortedPunchesArray;
    }

    private function GetScheduledEmplId($daySchedules){
        $emplIDs = array();

        $lastEmployee = 0;
        for($k = 0; $k < count($daySchedules); $k++) {

            if ($lastEmployee === 0) {

                $lastEmployee = $daySchedules[$k]->idEmployee;

                $object = (object) array('id' => (int)$daySchedules[$k]->idEmployee,
                    "firstName" => $daySchedules[$k]->firstName,
                    "lastName" => $daySchedules[$k]->lastName);

                array_push($emplIDs, $object);

            } else if ($lastEmployee !=  $daySchedules[$k]->idEmployee){
                $object = (object) array('id' => (int)$daySchedules[$k]->idEmployee,
                    "firstName" => $daySchedules[$k]->firstName,
                    "lastName" => $daySchedules[$k]->lastName);

                $lastEmployee = $daySchedules[$k]->idEmployee;
                array_push($emplIDs, $object);
            }
        }
        return $emplIDs;
    }

    private function SortEmployeeDaySchedules($employeeId, $daySchedules){
        $sortedDaySchedulesArray = array();
        for($k = 0; $k < count($daySchedules); $k++) {

            if ($daySchedules[$k]->idEmployee == $employeeId) {

                array_push($sortedDaySchedulesArray, $daySchedules[$k]);

            }
        }
        return $sortedDaySchedulesArray;
    }

    private function FindEmployeeOnTrackPunch($daySchedules, $punches){
        $correspnds = array();
        $acc_correspnds = array();

        $e = new DateTime('00:00');
        $dtScheduled = new DateTime('00:00');

        $f = clone($e);
        $acc_total_Payed = 0;

        For($i = 0; $i < count($daySchedules); $i++){

            $scheduledInterval = Utils::GetInterval($daySchedules[$i]->startTime, $daySchedules[$i]->endTime);
            $dtScheduled->add($scheduledInterval);

            unset($correspnds);
            $correspnds = array();
            For($j = 0; $j < count($punches); $j++) {

                if (Utils::IsBetweenInterval($daySchedules[$i]->startTime, $punches[$j]->startTime, $daySchedules[$i]->endTime, $punches[$j]->endTime, 30)) {
                    $int = Utils::GetInterval($punches[$j]->startTime, $punches[$j]->endTime);

                    $f->add($int);
                    $punches[$j]->interval = $int;

                    $payInDollar = Utils::CalculateSalary($int, $punches[$j]->baseSalary + $punches[$j]->bonusSalary);

                    $acc_total_Payed += $payInDollar;
                    $punches[$j]->totalPay = $payInDollar;

                    if (!isset($acc_corresp[$punches[$j]->id])) {
                        $correspnds[$punches[$j]->id] = $punches[$j];
                        $acc_correspnds[$punches[$j]->id] = $punches[$j];
                    }

                }
            }
            $daySchedules[$i]->corresps = $correspnds;
        }

        $summary = array(
            'scheduled' => $dtScheduled,
            'worked' => $f->diff($e),
            'cost' => $acc_total_Payed,
            'punches' => $acc_correspnds,
            'daySchedules' => $daySchedules
        );
        return $summary;
    }

    private function PunchArrayDiff($matches, $punches) {
        $punchs = array();

        $e = new DateTime('00:00');
        $f = clone($e);
        $acc_total_Payed = 0;

        foreach($punches as $km => $objPunch) {
            $isFound = false;
            foreach ($matches as $kp => $objMatch) {
                if((int)($objPunch->id) === (int)($objMatch->id)){
                    $isFound = true;
                }
            }
            if(!$isFound){
                $punchs[] = $objPunch;

                $int = Utils::GetInterval($objPunch->startTime, $objPunch->endTime);

                $f->add($int);
                $objPunch->interval = $int;

                $payInDollar = Utils::CalculateSalary($int, $objPunch->baseSalary + $objPunch->bonusSalary);
                $acc_total_Payed += $payInDollar;

                $objPunch->totalPay = $payInDollar;
            }
        }

        $summary = array(
            'worked' => $f->diff($e),
            'cost' => $acc_total_Payed,
            'punches' => $punchs
        );
        return $summary;
    }

    // Cette fonction sert a prendre une matrice de temps et a faire les
    // calculs de la matrice.
    // Return: The initial matrix with total and interval
    private function CalculateSchedulesAndPunches($daySchedules, $punches){

        $employeeIDs = $this->GetScheduledEmplId($daySchedules);
        $totalEmplWorkedHours = new DateTime('00:00');
        $totalEmplScheduledHours = clone($totalEmplWorkedHours);
        $totalCost = 0;

        $f = clone($totalEmplWorkedHours);

        for($i = 0; $i < count($employeeIDs); $i++){

            $employeeDaySchedules = $this->SortEmployeeDaySchedules($employeeIDs[$i]->id, $daySchedules);
            $employeePunches = $this->SortEmployeePunches($employeeIDs[$i]->id, $punches);

            $vals = $this->FindEmployeeOnTrackPunch($employeeDaySchedules, $employeePunches);

            $offTracks = $this->PunchArrayDiff($vals["punches"], $employeePunches);

            // The SUM for worked hours
            $dtWorkd = new DateTime('00:00');

            $totalCostPerEmployee = 0;

            $dtWorkd->add($vals["worked"]);
            $dtWorkd->add($offTracks["worked"]);

            $totalEmplWorkedHours->add($vals["worked"]);
            $totalEmplWorkedHours->add($offTracks["worked"]);

            $totalEmplScheduledHours->add($f->diff($vals["scheduled"]));

            $totalCostPerEmployee += $vals["cost"];
            $totalCostPerEmployee += $offTracks["cost"];

            $totalCost += $totalCostPerEmployee;

            $totalMinutes = Utils::CalculateMinutes($f->diff($dtWorkd)) - Utils::CalculateMinutes($f->diff($vals["scheduled"]));
            //$schedule[$startIndex]->difference = Utils::MinutesToTimeString($totalMinutes);

            $employeeIDs[$i]->daySchedules = $vals["daySchedules"];
            $employeeIDs[$i]->infos = (object)array(
                "scheduled" => Utils::IntervalToString($f->diff($vals["scheduled"])),
                "worked" => Utils::IntervalToString($f->diff($dtWorkd)),
                "difference" => Utils::MinutesToTimeString($totalMinutes),
                "cost" => $totalCostPerEmployee
            );
            $employeeIDs[$i]->offTracks = $offTracks["punches"];
        }
        $scheduleInfos = array();
        $summary = array(
            'scheduled' => Utils::IntervalToString($f->diff($totalEmplScheduledHours)),
            'worked' => Utils::IntervalToString($f->diff($totalEmplWorkedHours)),
            'cost' => $totalCost
        );

        $scheduleInfos['summary'] = $summary;
        $scheduleInfos['grid'] = $employeeIDs;
        // On met le sommaire et le grille dans l<object
        return $scheduleInfos;
    }




    public function track($id)
    {
        $schedule = Schedule::GetById($id);
        $scheduleInfos = $this->CalculateSchedulesAndPunches(Schedule::GetScheduleEmployees($id),
            Punch::GetByInterval($schedule->startDate, $schedule->endDate));
        //$punches = $this->CalculateSchedulesAndPunches());

        $view = \View::make('POS.Schedule.track')->with('ViewBag', array(
            'schedule' => $schedule,
            'scheduleInfos' => $scheduleInfos,
            //'punches' => $punches
        ));
        return $view;
    }

    // Attention a employee et employees ci-dessous.
    // Employees sort plus la liste des employeee pour un schedule
    public function employeesSchedule($scheduleid)
    {
        $schedule = Schedule::GetById($scheduleid);
        $employees = Schedule::getScheduledEmployees($scheduleid);
        $view = \View::make('POS.Schedule.employees')->with('ViewBag', array(
                'schedule' => $schedule,
                'employees' => $employees
            )
        );
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
                        <link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"css/schedule.css\">
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
