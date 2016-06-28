<?php
namespace App\Helpers;
use App\Models\POS\Disponibility;
use App\Models\POS\Schedule;


use DateInterval;
use DateTime;
/**
 * Created by PhpStorm.
 * User: Maype-IsaelBlais
 * Date: 2016-01-26
 * Time: 12:03
 */


class Utils
{
    static public function getDaySchedulesHtml($schedule, $scheduleInfosarr)
    {
        $htmlString = "";
        $currentDay = 0;
        $lastDay = 0;
        $monthArray = array (
            0 => "Dimanche",
            1 => "Lundi",
            2 => "Mardi",
            3 => "Mercredi",
            4 => "Jeudi",
            5 => "Vendredi",
            6 => "Samedi"
        );
        $htmlString = $htmlString . "<table><thead><tr><th>Full Name</th><th>Phone</th>";
        for($i = 0; $i < 7; $i++) {
            $htmlString = $htmlString . "<th class=\"dayCol\">";
            if($i == 0){
                $htmlString = $htmlString . "<h2>" . $monthArray[$i] . "</h2><h4>" . $schedule->startDate . "</h4>";
            } else {
                $htmlString = $htmlString . "<h2>" . $monthArray[$i] . "</h2><h4>" . date('Y-m-d', strtotime($schedule->startDate. ' + ' . $i .' days')) . "</h4>";
            }
            $htmlString = $htmlString . "</th>";
        }
        $htmlString = $htmlString . "</tr></thead>";
        $htmlString = $htmlString . "<tbody>";
        $userANDdaySchedules = array();

        // Code block for correctly sorting employees so we can build a easy schedule.
        for($i = 0; $i < count($scheduleInfosarr); $i++){
            if($i == 0){
                // We are at the first one, and need to insert.
                $userANDdaySchedules  += array($scheduleInfosarr[$i]->employee_id => array((array)$scheduleInfosarr[$i]));
            } else {
                $key = $scheduleInfosarr[$i]->employee_id;
                $result = isset($userANDdaySchedules[$key]) ? $userANDdaySchedules[$key] : null;
                // If we found a employee in the array.
                if($result){
                    // We are with the same user as last one.
                    $arrayDaySchedules = (array) $scheduleInfosarr[$i];
                    array_push($userANDdaySchedules[$key], $arrayDaySchedules);
                } else {
                    // We are browsing a new user from the last one.
                    $userANDdaySchedules  += array($scheduleInfosarr[$i]->employee_id => array((array)$scheduleInfosarr[$i]));
                }
            }
        }

        $count = 0;
        foreach($userANDdaySchedules as $emplNSchedules) {
            $arrayWeek = array("", "", "", "", "", "", "");
            $htmlString = $htmlString . "<tr>";
            $htmlString = $htmlString . "<td>" . $emplNSchedules[$count]['firstName'] . $emplNSchedules[$count]['lastName'] . "</td><td>" . $emplNSchedules[$count]['phone'] . "</td>";


            for ($k = 0; $k < count($emplNSchedules); $k++) {
                $dt = new DateTime($emplNSchedules[$k]['startTime']);
                $dte = new DateTime($emplNSchedules[$k]['endTime']);

                $key = (int)$dt->format('w');
                //$key = 0;//$emplNSchedules[$k]['day_number'];
                $text = $dt->format('H:i') . " to " . $dte->format('H:i');
                $arrayWeek[$key] = $arrayWeek[$key] . $text;
            }
            for ($j = 0; $j < count($arrayWeek); $j++) {
                if($arrayWeek[$j] == ""){
                    $htmlString = $htmlString . "<td></td>";
                } else {
                    $htmlString = $htmlString . "<td>" . $arrayWeek[$j] . "</td>";
                }
            }
        }

        // substr($emplNSchedules[$k]['startTime'], 0, -3) . " to " . substr($emplNSchedules[$k]['endTime'], 0, -3) . "<br />";

        $htmlString = $htmlString . "</tbody>";
        $htmlString = $htmlString . "</table>";
        //var_dump($userANDdaySchedules);
        return $htmlString;
    }

    // Calculate interval from 2 DateTime string in the format y-m-d h:i:s
    // Return DateInterval Object.
    static public function GetInterval($start, $end){
        $datetime1 = new DateTime($start);
        $datetime2 = new DateTime($end);

        return $datetime1->diff($datetime2);
    }

    // Calculate hours from DateInterval Object
    // Return array with hours and minutes.
    static public function CalculateMinutes($interval){


        $hours = ($interval->h + ($interval->d * 24))*60;
        $mins = $interval->i;

        return ($hours + $mins);

    }

    // Calculate salary from interval
    // IN: $interval between two moment,
    // $finalSalary of the person context: baseSalary + BonusSalary
    // Return The pay in dollar.
    static public function CalculateSalary($interval, $finalSalary){

        $hours = ($interval->h + ($interval->d * 24))*60;
        $mins = $interval->i;

        $salary = $finalSalary / 60;
        $worktime = $hours + $mins;
        $pay = $worktime* $salary; // This result is in cents

        return $pay;

    }

    // Calculate hours from DateInterval Object
    // Return array with hours and minutes.
    static public function MinutesToTimeString($minutes){

        $sign_Char = "";
        if($minutes < 0){
            $minutes = $minutes * -1;
            $sign_Char = "-";
        } else {
            $sign_Char = "+";
        }

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        return $sign_Char . ($hours < 10 ? '0' . $hours : $hours) . ":" . ($mins < 10 ? '0' . $mins : $mins);

    }

    // Calculate hours from DateInterval Object
    // Return formatted string time.
    static public function IntervalToString($interval){


        $hours = $interval->h + ($interval->d * 24);
        $mins = $interval->i;

        return ($hours < 10 ? '0' . $hours : $hours) . ":" . ($mins < 10 ? '0' . $mins : $mins);

    }

    // Calculate hours from DateInterval Object
    // Return formatted string time.
    static public function IsBetweenInterval($st1, $st2, $et1, $et2, $mins_tolerance){

        // Schedule
        $startTime1 = new DateTime($st1);
        // Punch
        $startTime2 = new DateTime($st2);
        // Schedule
        $endTime1 = new DateTime($et1);
        // Punch
        $endTime2 = new DateTime($et2);

        //$interval = new DateInterval('PT' . $mins_tolerance . 'M');

        //$startTime1->sub($interval);
        //$endTime1->sub($interval);


        if($startTime2 >= $startTime1 && $endTime1 <= $endTime2){
            return true;
        } else {
            return false;
        }

    }
}