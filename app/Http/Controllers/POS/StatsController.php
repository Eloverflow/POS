<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
use App\Models\POS\Schedule;
use App\Models\POS\Punch;
use App\Models\Project;
use Illuminate\Support\Facades\Input;
use App\Models\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Helpers\Utils;
use DateInterval;
use DateTime;

class StatsController extends Controller
{
    public function index()
    {

        // For bar chart Monthly scheduled & worked hours
        $rawWorkedHours = activity(date("Y"));
        $rawScheduledHours = Schedule::GetScheduledHoursYear(date("Y"));
        $workedHours = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,);
        $scheduledHours = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,);

        $curDateTime = new DateTime();
        foreach($rawWorkedHours as $monthWorkedHours){
            $parts   = explode(':', $monthWorkedHours->total);
            $workedHours[$monthWorkedHours->month] = $parts[0];
        }
        foreach($rawScheduledHours as $monthSheduledHours){
            $parts   = explode(':', $monthSheduledHours->total);
            $scheduledHours[$monthSheduledHours->month] = $parts[0];
        }
        $view = \View::make('POS.stats.index')->with('ViewBag', array(
                'workedHours' => $workedHours,
                'scheduledHours' => $scheduledHours
            ));
        
        
        
        return $view;
    }


}
