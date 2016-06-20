<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Schedule;
use App\Models\POS\Punch;
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

class StatsController extends Controller
{
    public function index()
    {
        // For bar chart Monthly scheduled & worked hours
        $rawWorkedHours = Punch::GetWorkedHoursYear(date("Y"));
        $rawScheduledHours = Schedule::GetScheduledHoursYear(date("Y"));
        $workedHours = $scheduledHours = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,);
        foreach($rawWorkedHours as $monthWorkedHours){

            $workedHours[$monthWorkedHours->month] = (int)(Datetime::createFromFormat('H:i:s', $monthWorkedHours->total)->format('h'));
        }
        foreach($rawScheduledHours as $monthSheduledHours){

            $scheduledHours[$monthSheduledHours->month] = (int)(Datetime::createFromFormat('H:i:s', $monthSheduledHours->total)->format('h'));
        }
        $view = \View::make('POS.stats.index')->with('ViewBag', array(
                'workedHours' => $workedHours,
                'scheduledHours' => $scheduledHours
            ));
        return $view;
    }


}
