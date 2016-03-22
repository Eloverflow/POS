<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Day_Disponibilities;
use App\Models\POS\Disponibility;
use App\Models\POS\Employee;
use App\Helpers\Utils;
use App\Models\POS\EmployeeTitle;
use App\Models\Project;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DateInterval;
use DateTime;

class DisponibilityController extends Controller
{
    public function index()
    {
        $disponibilities = Disponibility::getAll();
        $view = \View::make('POS.Disponibility.index')->with('ViewBag', array(
            'disponibilities' => $disponibilities
        ));
        return $view;
    }

    public function details($id)
    {

        $disponibility = Disponibility::GetById($id);

        $weekDispos = array(
            0 => Disponibility::GetDayDisponibilities($id, 0),
            1 => Disponibility::GetDayDisponibilities($id, 1),
            2 => Disponibility::GetDayDisponibilities($id, 2),
            3 => Disponibility::GetDayDisponibilities($id, 3),
            4 => Disponibility::GetDayDisponibilities($id, 4),
            5 => Disponibility::GetDayDisponibilities($id, 5),
            6 => Disponibility::GetDayDisponibilities($id, 6),
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
                    $date->modify('Sunday last week +' . $dayNumber . ' days');
                    //$date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime);

                   /* if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }*/

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
            'timezone' => false, 'local', 'EST', 'America/Montreal',
            'editable' => false,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
        ]);

        $view = \View::make('POS.Disponibility.details')->with('ViewBag', array(
            'disponibility' => $disponibility,
            'calendar' => $calendar
                )
            );
        return $view;
    }

    public function edit($id)
    {
        $disponibility = Disponibility::GetById($id);
        $employees = Employee::getAll();

        $weekDispos = array(
            0 => Disponibility::GetDayDisponibilities($id, 0),
            1 => Disponibility::GetDayDisponibilities($id, 1),
            2 => Disponibility::GetDayDisponibilities($id, 2),
            3 => Disponibility::GetDayDisponibilities($id, 3),
            4 => Disponibility::GetDayDisponibilities($id, 4),
            5 => Disponibility::GetDayDisponibilities($id, 5),
            6 => Disponibility::GetDayDisponibilities($id, 6),
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
                    $date->modify('Sunday last week +' . $dayNumber . ' days');
                    //$date->add(new DateInterval('P' . $i .'D'));

                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime);

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
            'timezone' => 'America/Montreal',
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ dispoClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Disponibility.edit')->with('ViewBag', array(
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
        //return json_encode("ahahahah");
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
            return json_encode('Validation Error');

        }
        else {


            Disponibility::where('id',\Input::get('dispoId'))
            ->update([
                'employee_id' => \Input::get('employeeSelect'),
                'name' => \Input::get('name')
            ]);

            Disponibility::DeleteDayDisponibilities(\Input::get('dispoId'));

            $jsonArray = json_decode(\Input::get('events'), true);
            for ($i = 0; $i < count($jsonArray); $i++) {
                //$jsonObj = json_decode(\Input::get('events')[$i], true);
                $dateStart = new DateTime($jsonArray[$i]["StartTime"]);
                $resStart = $dateStart->format('H:i:s');
                $dateStop = new DateTime($jsonArray[$i]["EndTime"]);
                $resStop = $dateStop->format('H:i:s');

                //$date = date("H:i:s", $jsonArray[$i]["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => \Input::get('dispoId'),
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

            }
        }
    }

    public function create()
    {
        $events = [];
        $employees = Employee::getAll();
        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            //'firstDay' => 1,
            'timezone' => false, 'local', 'EST', 'America/Montreal',
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ dispoClick(jsEvent, xEvent);}",
            'dayClick' => "function(date, xEvent, view) { dayClick(date, xEvent); }"
        ]);

        $view = \View::make('POS.Disponibility.create')->with('ViewBag', array(
                'employees' => $employees,
                'calendar' => $calendar
            )
        );
        return $view;

    }

    public function postCreate()
    {
        $inputs = \Input::all();
        //return json_encode("ahahahah");
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
            return json_encode('Validation Error');

        }
        else
        {

            $disponiblity = Disponibility::create([
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
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => $jsonArray[$i]["dayIndex"],
                    "startTime" => $resStart,
                    "endTime" => $resStop
                ]);

            }

            //var_dump(\Input::get('name'));
            //var_dump();
            //$jsonObj = json_decode(\Input::get('events'));
            //$jsonObj = json_encode(\Input::get('events'));

            return json_encode($jsonArray[0]['StartTime']);
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
