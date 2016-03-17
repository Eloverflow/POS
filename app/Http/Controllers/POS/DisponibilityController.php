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



                    $date = new DateTime(Disponibility::all()->first()->startDate);
                    $date->add(new DateInterval('P' . $i .'D'));

                    /*
                                        $currentDay = date('Y-m-d', strtotime('+' . $i . ' day', Schedule::all()->first()->startDate));*/


                    $dispoBegin = new DateTime($date->format('Y-m-d') . " " . $startTime);
                    $dispoEnd = new DateTime($date->format('Y-m-d') . " " . $endTime);

                    if($dispoBegin->format('%H') > $dispoEnd->format('%H')){
                        $dispoEnd->add(new DateInterval('P1D'));
                    }

                    $events[] = \Calendar::event(
                        $startTime . " to " . $endTime, //event title
                        false, //full day event?
                        $dispoBegin, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                        $dispoEnd, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                        1
                    );

                    //var_dump($events);
                }
            }
        }

        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => 'function() {alert("Callbacks!");}'
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
        $employees = Employee::getAll();
        $disponibility = Disponibility::GetById($id);
        $employeeTitles = EmployeeTitle::All();
        $WeekDisponibilities = array(
            0 => Disponibility::GetDayDisponibilities($id, 0),
            1 => Disponibility::GetDayDisponibilities($id, 1),
            2 => Disponibility::GetDayDisponibilities($id, 2),
            3 => Disponibility::GetDayDisponibilities($id, 3),
            4 => Disponibility::GetDayDisponibilities($id, 4),
            5 => Disponibility::GetDayDisponibilities($id, 5),
            6 => Disponibility::GetDayDisponibilities($id, 6),
        );
        //DB::table('users')->get();
        $view = \View::make('POS.Disponibility.edit')->with('ViewBag', array(
            'employees' => $employees,
            'disponibility' => $disponibility,
            'weekDispos' => $WeekDisponibilities,
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
            return \Redirect::action('POS\DisponibilityController@edit')->withErrors($validation)
                ->withInput();

        }
        else
        {
            $idDisponibility = \Input::get('idDisponibility');

            // On commence par supprimer tous les jour de disponiblite associer a une disponibilite.
            Disponibility::DeleteDayDisponibilities($idDisponibility);

            Disponibility::where('id', $idDisponibility)
            ->update([
                'name' => \Input::get('name'),
                'employee_id' => \Input::get('employeeSelect'),
            ]);

            for($i = 0; $i < count(\Input::get('sunDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('sunDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 0,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('monDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('monDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 1,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('tueDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('tueDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 2,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('wedDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('wedDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 3,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('thuDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('thuDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 4,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('friDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('friDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 5,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('satDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('satDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $idDisponibility,
                    "day_number" => 6,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }
            //var_dump(\Input::get('name'));
            //var_dump(\Input::get('sunDispos'));

            return \Redirect::action('POS\DisponibilityController@index')->withSuccess('The disponibility has been successfully edited !');
        }
    }

    public function create()
    {
        $events = [];
        $employees = Employee::getAll();
        $colSettings = array('columnFormat' => 'ddd');
        $calendar = \Calendar::addEvents($events)->setOptions([
            'editable' => true,
            'header' => false,
            'defaultView' => 'agendaWeek',
            'views' => array('agenda' => $colSettings)
        ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
            'eventClick' => "function (xEvent, jsEvent, view){ dispoClick(xEvent);}",
            'eventAfterAllRender' => "function () { writeAllEvents(); }"
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

        $rules = array(
            'name' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return \Redirect::action('POS\DisponibilityController@create')->withErrors($validation)
                ->withInput();

        }
        else
        {

            $disponiblity = Disponibility::create([
                'employee_id' => \Input::get('employeeSelect'),
                'name' => \Input::get('name')
            ]);
            for($i = 0; $i < count(\Input::get('sunDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('sunDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 0,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('monDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('monDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 1,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('tueDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('tueDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 2,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('wedDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('wedDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 3,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('thuDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('thuDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 4,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('friDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('friDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 5,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }

            for($i = 0; $i < count(\Input::get('satDispos')); $i++)
            {
                $jsonObj = json_decode(\Input::get('satDispos')[$i], true);
                //var_dump($jsonObj["StartTime"]);
                Day_Disponibilities::create([
                    "disponibility_id" => $disponiblity->id,
                    "day_number" => 6,
                    "startTime" => $jsonObj["StartTime"] . ":00",
                    "endTime" => $jsonObj["EndTime"] . ":00"
                ]);
            }
            //var_dump(\Input::get('name'));
            //var_dump(\Input::get('sunDispos'));

            return \Redirect::action('POS\DisponibilityController@index')->withSuccess('The disponibility has been successfully created !');
        }
    }

    public function delete($id)
    {
        $employee = Employee::GetById($id);
        $view = \View::make('POS.Employee.delete')->with('employee', $employee);
        return $view;
    }
}
