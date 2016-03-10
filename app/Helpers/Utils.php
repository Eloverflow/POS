<?php
namespace App\Helpers;
use App\Models\POS\Disponibility;
use App\Models\POS\Schedule;
use App\Models\POS\Shared\Cell;
use App\Models\POS\Shared\Row;
use App\Models\POS\Shared\Intersect;
use App\Models\POS\Shared\ScheduleCell;

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
            0 => "Sunday",
            1 => "Monday",
            2 => "Tuesday",
            3 => "Wednesday",
            4 => "Thursday",
            5 => "Friday",
            6 => "Saturday"
        );
        //var_dump($ViewBag['scheduleInfos']);
        for($i = 0; $i < 7; $i++) {
            $htmlString = $htmlString . "<div class=\"trackBloc\">";
            if($i == 0){
                $htmlString = $htmlString . "<h2>" . $monthArray[$i] . "</h2><h4>" . $schedule->startDate . "</h4>";
            } else {
                $htmlString = $htmlString . "<h2>" . $monthArray[$i] . "</h2><h4>" . date('Y-m-d', strtotime($schedule->startDate. ' + ' . $i .' days')) . "</h4>";
            }

            $lastPerson = "";

            $current = "";
            $personCounter = 0;



            foreach ($scheduleInfosarr as $scheduleInfos) {

                $currentDay = $i;
                $currentPerson = $scheduleInfos->firstName . " " . $scheduleInfos->lastName;


                if($lastPerson != $currentPerson || $personCounter == 0){

                    if($personCounter > 0){
                        $htmlString = $htmlString . "</div>";
                    }

                    if($scheduleInfos->day_number == $i) {
                        $personCounter++;
                        $htmlString = $htmlString . "<div class=\"emplTrackBlock\">
                                        <h4>" . $scheduleInfos->firstName . " " . $scheduleInfos->lastName . "</h4><h5>" . $scheduleInfos->emplTitle . "</h4>" .
                            "<p>" . $scheduleInfos->startTime . " To " . $scheduleInfos->endTime . "</p>";

                    }

                }
                else{

                    if($scheduleInfos->day_number == $i) {
                        $htmlString = $htmlString . "<p>" . $scheduleInfos->startTime . " To " . $scheduleInfos->endTime . "</p>";
                    }
                }

                $lastPerson = $currentPerson;
            }
            if($personCounter > 0){
                $htmlString = $htmlString . "</div>";
            }

            $lastDay = $currentDay;
            $htmlString = $htmlString . "</div>";
        }
        return $htmlString;
    }
}