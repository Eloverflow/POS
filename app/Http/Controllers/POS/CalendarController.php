<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\POS\Employee;
use App\Models\Beer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use URL;
use Validator;

use DateTime;
use DateInterval;
class CalendarController extends Controller
{

    public  function index()
    {
        $events = [];

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $strCalendar = "[Semaine du " . $lastSundayStr . " au " . $lastDay->format('Y-m-d') . "]";

        $calendarSettings = array('left' => 'month,agendaWeek,agendaDay',
            'center' => 'title',
            'right' => 'prev, next');

        $employees = Employee::getAll();
        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => false,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'titleFormat' => $strCalendar,
            'lang' => 'fr-ca'
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ scheduleClick(xEvent, jsEvent, view);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Calendar.index')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar,
                'startDate' => $lastSundayStr,
                'endDate' => $lastDay->format('Y-m-d')
            )
        );
        return $view;
    }

    public  function edit()
    {
        $events = [];

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $strCalendar = "[Semaine du " . $lastSundayStr . " au " . $lastDay->format('Y-m-d') . "]";

        $calendarSettings = array('left' => 'month,agendaWeek,agendaDay',
            'center' => 'title',
            'right' => 'prev, next');

        $employees = Employee::getAll();
        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => true,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'titleFormat' => $strCalendar, // $strCalendar,
            'lang' => 'fr-ca'
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ scheduleClick(xEvent, jsEvent, view);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }",
            'viewRender' => "function(view, element) { calendarViewRender(view, element); }"
        ]);

        $view = \View::make('POS.Calendar.edit')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar,
                'startDate' => $lastSundayStr,
                'endDate' => $lastDay->format('Y-m-d')
            )
        );
        return $view;
    }

    public function create()
    {


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
}