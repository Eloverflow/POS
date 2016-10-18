<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\POS\Employee;
use App\Models\Beer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Client;
use App\Models\POS\MomentType;
use App\Models\POS\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
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
        $calendarEvents = $this->GetCalendarEvents();

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $strCalendar = "[Semaine du " . $lastSundayStr . " au " . $lastDay->format('Y-m-d') . "]";

        $calendarSettings = array('left' => 'month,agendaWeek,agendaDay',
            'center' => 'title',
            'right' => 'prev, next');

        $employees = Employee::getAll();
        $calendar = \Calendar::addEvents($calendarEvents)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => false,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'titleFormat' => $strCalendar,
            'lang' => 'fr-ca'
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
        $calendarEvents = $this->GetCalendarEvents();

        $date = new DateTime();
        $date->modify('Sunday last week');
        $lastSundayStr = $date->format('Y-m-d');

        $lastDay = $date->add(new DateInterval('P6D'));

        $strCalendar = "[Semaine du " . $lastSundayStr . " au " . $lastDay->format('Y-m-d') . "]";

        $calendarSettings = array('left' => 'month,agendaWeek,agendaDay',
            'center' => 'title',
            'right' => 'prev, next');

        $employees = Employee::getAll();
        $momentTypes = MomentType::getAll();

        $calendar = \Calendar::addEvents($calendarEvents)->setOptions([
            //'firstDay' => 1,
            'timezone' => 'local', 'EDT', ('America/Montreal'),
            'editable' => true,
            'defaultView' => 'agendaWeek',
            'header' => $calendarSettings,
            'titleFormat' => $strCalendar, // $strCalendar,
            'lang' => 'fr-ca',
            'forceEventDuration' => true,
            'defaultAllDayEventDuration' => '{ days: 1 }',
            'defaultTimedEventDuration' => '02:00:00'
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ scheduleClick(xEvent, jsEvent, view);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }",
            'viewRender' => "function(view, element) { calendarViewRender(view, element); }",
            'eventAfterAllRender' => "function() { eventAfterAllRender(); }"
            /*'eventDragStart' => "function( event, jsEvent, ui, view ) { eventDragStart(event); }",
            'eventDragStop' => "function( event, jsEvent, ui, view ) { eventDragStop(jsEvent); }",
            'eventDrop' => "function( event, delta, revertFunc, jsEvent, ui, view ) { eventDrop(event); }"*/
        ]);

        $view = \View::make('POS.Calendar.edit')->with('ViewBag', array(
                'employees' => $employees,
                'momentTypes' => $momentTypes,
                'calendar' => $calendar,
                'calendarEvents' => $calendarEvents,
                'startDate' => $lastSundayStr,
                'endDate' => $lastDay->format('Y-m-d')
            )
        );
        return $view;
    }

    public function postEdit()
    {
        $inputs = Input::all();

        $rules = array(

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

            $jsonArray = json_decode(Input::get('events'), true);
            for($i = 0; $i < count($jsonArray); $i++)
            {
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $employeeId = isset($jsonArray[$i]["employeeId"]) ? $jsonArray[$i]["employeeId"]: null;
                $momentTypeId = $jsonArray[$i]["momentTypeId"];
                $eventName = isset($jsonArray[$i]["name"]) ? $jsonArray[$i]["name"]: null;
                $isAllDay = isset($jsonArray[$i]["isAllDay"]) ? 0 : 1;


                CalendarEvent::create([
                    "name" => $eventName,
                    "isAllDay" => $isAllDay,
                    "moment_type_id" => $momentTypeId,
                    'employee_id' => $employeeId,
                    "startTime" => $dateStart,
                    "endTime" => $dateStop
                ]);

            }

            return \Response::json([
                'success' => "The Calendar " . Input::get('name') . " has been successfully edited !"
            ], 201);
        }
    }

    private function GetCalendarEvents() {

        $events = [];

        $calendarEvents = CalendarEvent::GetCalendarMoments();

        for($i = 0; $i < count($calendarEvents); $i++){

            $startDatewithTMZ =  date_create($calendarEvents[$i]->startTime, timezone_open('America/Montreal'));
            $startOffset = date_offset_get($startDatewithTMZ);
            $offsetInHourFormat = ($startOffset /60) /60;

            $availableColor = "";
            switch($calendarEvents[$i]->momentTypeId){
                case 1:
                    $availableColor = "#0C0C50";
                    break;
                case 2:
                    $availableColor = "#b30000";
                    break;
                case 3:
                    $availableColor = "#003300";
                    break;
            }

            $momentStart = new DateTime($calendarEvents[$i]->startTime . $offsetInHourFormat);
            $momentEnd = new DateTime($calendarEvents[$i]->endTime . $offsetInHourFormat);

            $events[] = \Calendar::event(
                $calendarEvents[$i]->momentTypeName . " - " . $calendarEvents[$i]->name,
                false, //full day event?
                $momentStart, //start time, must be a ateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $momentEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $calendarEvents[$i]->id,
                [
                    'eventId' => $calendarEvents[$i]->id,
                    'eventName' => $calendarEvents[$i]->name,
                    'color' => $availableColor,
                    'employeeId' => $calendarEvents[$i]->employee_id,
                    'momentTypeId' => $calendarEvents[$i]->momentTypeId
                ]
            );

        }
        return $events;
    }
}