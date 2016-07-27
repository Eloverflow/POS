<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Day_Availability;
use App\Models\POS\Availability;
use App\Models\POS\Employee;
use App\Helpers\Utils;
use App\Models\POS\EmployeeTitle;
use App\Models\Project;
use App\Models\Auth\User;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DateInterval;
use DateTime;

class AvailabilityController extends Controller
{
    public function index()
    {
        $availability = Availability::getAll();
        $view = \View::make('POS.Availability.index')->with('ViewBag', array(
            'availability' => $availability
        ));
        return $view;
    }

    public function details($id)
    {

        $disponibility = Availability::GetById($id);

        $weekDispos = array(
            0 => Availability::GetDayDisponibilities($id, 0),
            1 => Availability::GetDayDisponibilities($id, 1),
            2 => Availability::GetDayDisponibilities($id, 2),
            3 => Availability::GetDayDisponibilities($id, 3),
            4 => Availability::GetDayDisponibilities($id, 4),
            5 => Availability::GetDayDisponibilities($id, 5),
            6 => Availability::GetDayDisponibilities($id, 6),
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
                    $dayNumber = $weekDispos[$i][$j]->day_number;


                    $date = new DateTime();
                    $startDatewithTMZ =  date_create($date->format('Y-m-d'), timezone_open('America/Montreal'));
                    $startOffset = date_offset_get($startDatewithTMZ);
                    $offsetInHourFormat = ($startOffset /60) /60;

                    $date->modify('Sunday last week +' . $dayNumber . ' days');

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime. $offsetInHourFormat);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime. $offsetInHourFormat);

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        "Dispo",
                        false,
                        $dispoBegin,
                        $dispoEnd,
                        $weekDispos[$i][$j]->id
                    );
                }
            }
        }

        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => false,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        ]);

        $view = \View::make('POS.Availability.details')->with('ViewBag', array(
            'disponibility' => $disponibility,
            'calendar' => $calendar
                )
            );
        return $view;
    }

    public function edit($id)
    {
        $disponibility = Availability::GetById($id);
        $employees = Employee::getAll();

        $weekDispos = array(
            0 => Availability::GetDayDisponibilities($id, 0),
            1 => Availability::GetDayDisponibilities($id, 1),
            2 => Availability::GetDayDisponibilities($id, 2),
            3 => Availability::GetDayDisponibilities($id, 3),
            4 => Availability::GetDayDisponibilities($id, 4),
            5 => Availability::GetDayDisponibilities($id, 5),
            6 => Availability::GetDayDisponibilities($id, 6),
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
                    $dayNumber = $weekDispos[$i][$j]->day_number;


                    $date = new DateTime();
                    $startDatewithTMZ =  date_create($date->format('Y-m-d'), timezone_open('America/Montreal'));
                    $startOffset = date_offset_get($startDatewithTMZ);
                    $offsetInHourFormat = ($startOffset /60) /60;

                    $date->modify('Sunday last week +' . $dayNumber . ' days');
                    //$date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime. $offsetInHourFormat);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime. $offsetInHourFormat);

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        "Dispo",
                        false,
                        $dispoBegin,
                        $dispoEnd,
                        $weekDispos[$i][$j]->id
                    );

                }
            }
        }

        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ dispoClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Availability.edit')->with('ViewBag', array(
                'disponibility' => $disponibility,
                'calendar' => $calendar,
                'employees' => $employees
            )
        );
        return $view;
    }

    public function postEdit()
    {
        $inputs = \Input::all();

        $rules = array(
            'name' => 'required',
            'employeeSelect' => 'required',
            'dispoId' => 'required'
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


            Availability::where('id',\Input::get('dispoId'))
            ->update([
                'employee_id' => \Input::get('employeeSelect'),
                'name' => \Input::get('name')
            ]);

            Availability::DeleteDayDisponibilities(\Input::get('dispoId'));

            $jsonArray = json_decode(\Input::get('events'), true);
            for ($i = 0; $i < count($jsonArray); $i++) {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $resStart = $dateStart->format('H:i:s');
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $resStop = $dateStop->format('H:i:s');

                //$date = date("H:i:s", $jsonArray[$i]["StartTime"]);
                Day_Availability::create([
                    "disponibility_id" => \Input::get('dispoId'),
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

            }

            return \Response::json([
                'success' => "The Availability " . \Input::get('name') . " has been successfully edited !"
            ], 201);
        }
    }

    public function create()
    {
        $events = [];
        $employees = Employee::getAll();
        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ dispoClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Availability.create')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar
            )
        );
        return $view;

    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'name' => 'required',
            'employeeSelect' => 'required'
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

            $disponiblity = Availability::create([
                'employee_id' => \Input::get('employeeSelect'),
                'name' => \Input::get('name')
            ]);

            $jsonArray = json_decode(\Input::get('events'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $resStart = $dateStart->format('H:i:s');
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $resStop = $dateStop->format('H:i:s');

                //$date = date("H:i:s", $jsonArray[$i]["StartTime"]);
                Day_Availability::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

            }

            return \Response::json([
                'success' => "The Availability " . \Input::get('name') . " has been successfully created !"
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
