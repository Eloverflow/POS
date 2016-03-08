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

/* shdyhsyhsys */

class Utils
{
    static public function CalculateIntersects($Hour, $weekDispos)
    {

        $countIntersects = 0;
        $Intersects = array();
        for ($j = 0; $j < 7; $j++) {
            $diposJour = $weekDispos[$j];
            for ($k = 0; $k < count($diposJour); $k++) {
                $DTST = new \DateTime($diposJour[$k]->startTime);
                $StartTime = $DTST->format('H');
                $StartMin = $DTST->format('i');
                $DTET = new \DateTime($diposJour[$k]->endTime);
                $EndTime = $DTET->format('H');
                $EndMin = $DTET->format('i');
                $diff = $EndTime - $StartTime;
                $realEndTime = "";
                //if ($EndTime > $StartTime) {
                    if (($Hour < $EndTime && $Hour > $StartTime)) {
                        if ($StartTime != 0) {
                            $newInters = new Intersect("current", $j, $Hour, $EndTime, $StartMin, $EndMin);
                        }

                        $countIntersects = $countIntersects + 1;
                        $Intersects[] = $newInters;
                    } else if ($StartTime == $Hour) {
                        if($EndTime == 0) {
                            $correctEndTime = 24;
                        }  else if($EndTime < $StartTime) {
                            $correctEndTime = 25;
                            $realEndTime = $EndTime;
                            // On ajoute des current pour l<overflow des chedules

                            if($EndTime > 1)
                            {
                                $newInters = new Intersect("overflow", $j + 1, 0, $EndTime, 0, 0);
                                $newInters->SetRealStartTime($StartTime);
                                $Intersects[] = $newInters;
                            }
                        } else {
                            $correctEndTime = $EndTime;
                        }
                        $newInters = new Intersect("start", $j, $Hour, $correctEndTime, $StartMin, $EndMin);


                        if($realEndTime != ""){
                            $newInters->SetRealEndTime($realEndTime);
                        }

                        //$newInters = new Intersect("start", $j, $Hour, $correctEndTime, $StartMin, $EndMin);

                        $countIntersects = $countIntersects + 1;
                        $Intersects[] = $newInters;
                    }
                //} else {

                    /*$newInters = new Intersect("start", $j, 23, 24, $StartMin, $EndMin);
                    $countIntersects = $countIntersects + 1;
                    $Intersects[] = $newInters;*/
                //}
            }
        }

        return $Intersects ;
    }


    static public function GenerateScheduleTableForEmployee($id, $employeeId)
    {
        $Cells = null;

        $WeekDisponibilities = array(
            0 => Schedule::GetDaySchedulesForEmployee($id, 0, $employeeId),
            1 => Schedule::GetDaySchedulesForEmployee($id, 1, $employeeId),
            2 => Schedule::GetDaySchedulesForEmployee($id, 2, $employeeId),
            3 => Schedule::GetDaySchedulesForEmployee($id, 3, $employeeId),
            4 => Schedule::GetDaySchedulesForEmployee($id, 4, $employeeId),
            5 => Schedule::GetDaySchedulesForEmployee($id, 5, $employeeId),
            6 => Schedule::GetDaySchedulesForEmployee($id, 6, $employeeId),
        );

        $BlankTable = Utils::GetBlankTable("");
        $arrangedTable = Utils::arrangeRows($BlankTable, $WeekDisponibilities);

        $count = 0;
        $rows = null;
        while($count < count($arrangedTable))
        {
            $row = $arrangedTable[$count];

            if($count < 9)
            {
                $firstCellText = "0" . ($count + 1) . ":00";
            } else {
                $firstCellText = ($count + 1) . ":00";
            }
            $rows[] = "<tr><td>" . $firstCellText . "</td>" . $row->ToString() . "</tr>";
            $count += 1;
        }

        return $rows;
    }

    static public function GenerateDisponibilityTable($id)
    {
        $Cells = null;

        $WeekDisponibilities = array(
            0 => Disponibility::GetDayDisponibilities($id, 0),
            1 => Disponibility::GetDayDisponibilities($id, 1),
            2 => Disponibility::GetDayDisponibilities($id, 2),
            3 => Disponibility::GetDayDisponibilities($id, 3),
            4 => Disponibility::GetDayDisponibilities($id, 4),
            5 => Disponibility::GetDayDisponibilities($id, 5),
            6 => Disponibility::GetDayDisponibilities($id, 6),
        );

        $BlankTable = Utils::GetBlankTable("");
        $arrangedTable = Utils::arrangeRows($BlankTable, $WeekDisponibilities);

        $count = 0;
        $rows = null;
        while($count < count($arrangedTable))
        {
            $row = $arrangedTable[$count];

            if($count < 9)
            {
                $firstCellText = "0" . ($count + 1) . ":00";
            } else {
                $firstCellText = ($count + 1) . ":00";
            }
            $rows[] = "<tr><td>" . $firstCellText . "</td>" . $row->ToString() . "</tr>";
            $count += 1;
        }

        return $rows;
    }

    static public function GenerateScheduleTable($id)
    {
        $Cells = null;

        $WeekDisponibilities = array(
            0 => Schedule::GetDaySchedules($id, 0),
            1 => Schedule::GetDaySchedules($id, 1),
            2 => Schedule::GetDaySchedules($id, 2),
            3 => Schedule::GetDaySchedules($id, 3),
            4 => Schedule::GetDaySchedules($id, 4),
            5 => Schedule::GetDaySchedules($id, 5),
            6 => Schedule::GetDaySchedules($id, 6),
        );


        $BlankTable = Utils::GetBlankTable("");
        $arrangedTable = Utils::arrangeScheduleRows($id, $BlankTable, $WeekDisponibilities);

        $count = 0;
        $rows = null;
        while($count < count($BlankTable))
        {
            $row = $BlankTable[$count];
            // Premiere colonne
            if($count < 9)
            {
                $firstCellText = "0" . ($count + 1) . ":00";
            } else {
                $firstCellText = ($count + 1) . ":00";
            }
            $rows[] = "<tr><td>" . $firstCellText . "</td>" . $row->ToString() . "</tr>";
            $count += 1;
        }

        return $rows;
    }

    static public function GetBlankTable($message)
    {
        $Rows = null;
        for($i = 0; $i < 24; $i++) {

            $Cells = null;

            for($j = 0; $j < 7; $j++)
            {
                $Cells[] = new Cell($message);
            }


            $Row = new Row($Cells);
            $Rows[] = $Row;
        }
        return $Rows;
    }

    static public function arrangeRows($rows, $weekDispos)
    {

        for($i = 1; $i < 24; $i++)
        {
            $normalIntersects = Utils::CalculateIntersects($i,$weekDispos);
            $curRow = $rows[$i -1];
            //var_dump($normalIntersects);
            for($j = 0; $j < count($normalIntersects); $j++) {
                $intersect = $normalIntersects[$j];

                if ($intersect->GetStartTime() < 10) {
                    $formattedStartTime = "0" . $intersect->GetStartTime() . ":" . $intersect->GetStartMin();
                } else {
                    $formattedStartTime = $intersect->GetStartTime() . ":" . $intersect->GetStartMin();
                }
                if ($intersect->GetEndTime() < 10) {
                    $formattedEndTime = $intersect->GetEndTime() . ":" . $intersect->GetEndMin();
                } else {
                    $formattedEndTime = $intersect->GetEndTime() . ":" . $intersect->GetEndMin();
                }

                if($intersect->GetType() == "start") {
                    $dayNumb = $intersect->GetDayNumber();

                    if($intersect->GetEndTime() > $intersect->GetStartTime()) {
                        $rowspan = $intersect->GetEndTime() - $intersect->GetStartTime();
                    } else {
                        $rowspan = 25 - $intersect->GetStartTime();
                    }
                    // Cela signifie que ce temps a un debordement
                    if($intersect->GetRealEndTime() != ""){
                        $cellText = $formattedStartTime . " <br />To<br /> " . $intersect->GetRealEndTime() . ":" . $intersect->GetEndMin();
                        $calcul = 24 - $intersect->GetStartTime();
                        for($k = 0; $k < $calcul; $k++){
                            $terow = $rows[$i + $k];
                            $terow->RemoveCell($dayNumb);
                        }
                    } else {
                        $cellText = $formattedStartTime . " <br />To<br /> " . $formattedEndTime;
                    }
                    // On efface les cellules de trop

                    $selluz = new Cell($cellText, $rowspan, "bluepalecell");

                    $curRow->SetCell($dayNumb, $selluz);
                } else if($intersect->GetType() == "current") {
                    $curRow = $rows[$i -1];
                    $dayNumb = $intersect->GetDayNumber();

                    $curRow->RemoveCell($dayNumb);
                } else if($intersect->GetType() == "overflow") {
                    $terow = $rows[$intersect->GetStartTime()];
                    $dayNumb = $intersect->GetDayNumber();
                    $rowspan = ($intersect->GetEndTime() - $intersect->GetStartTime()) - 1;

                    $cellText = $intersect->GetRealStartTime() . ":00 <br />To<br /> " . $intersect->GetEndTime() . ":00";
                    $selluz = new Cell($cellText, $rowspan, "bluepalecell");

                    $terow->SetCell($dayNumb, $selluz);
                }
            }
        }

        return $rows;
    }


    static public function arrangeScheduleRows($idSchedule, $rows, $weekDispos)
    {
        for($i = 1; $i < 25; $i++)
        {
            $intersects = Utils::CalculateIntersects($i,$weekDispos);
           // var_dump($intersects);
            //var_dump($intersects);
            $curRow = $rows[$i -1];
            //var_dump($intersects);
            for($j = 0; $j < 7; $j++)
            {

                $areWorking = 0;
                $areStarting = 0;

                for($k = 0; $k < count($intersects); $k++) {
                    if ($intersects[$k]->GetType() == "start" && $intersects[$k]->GetDayNumber() == $j) {
                        //var_dump($intersects[$k]);
                        $areStarting = $areStarting + 1;
                        $areWorking = $areWorking + 1;
                       //$cellText = "Startingt: (" . $areStarting . ") <br />Working: (" . $areWorking . ")";

                        // On trouve les employees qui travaillent
                        $employeesStarting =  Schedule::GetDaySchedulesHourStart($idSchedule, $j, $i);
                        $employeesWorking =  Schedule::GetDaySchedulesHour($idSchedule, $j, $i);

                        $array = array_merge($employeesStarting, $employeesWorking);
                        //var_dump($array);

                        $scheduleCell = new Cell("AHAH", 0, "bluepalecell", $array);
                        //$selluz = new Cell($cellText, 0, "bluepalecell");

                        $tehCell = $curRow->GetCell($j);
                        $tehCell->AddEmployee($employeesStarting);
                        $tehCell->setTxt("HOLO");

                        //var_dump($tehCell);
                        $curRow->SetCell($j, $tehCell);
                    } else if ($intersects[$k]->GetType() == "current" && $intersects[$k]->GetDayNumber() == $j) {
                        //var_dump($intersects[$k]);
                        $areWorking = $areWorking + 1;
                        $cellText = "Startingk: (" . $areStarting . ") <br />Working: (" . $areWorking . ")";
                        $selluz = new Cell($cellText, 0, "bluepalecell");

                        $curRow->SetCell($j, $selluz);
                    } else if ($intersects[$k]->GetType() == "overflow" && $intersects[$k]->GetDayNumber() == $j) {

                        //$areWorking = $areWorking + 1;
                        //$areStarting = $areStarting + 1;
                        //$cellText = "Starting: (" . $areStarting . ") <br />Working: (" . $areWorking . ")";
                        //$selluz = new Cell($cellText, 0, "bluepalecell");

                        //$curRow->SetCell($j, $selluz);
                        // On place l'overflow a la bonne place
                        $desiredRow = $rows[$intersects[$k]->GetStartTime()];
                        $cellText = "Starting: (" . $areStarting . ") <br />Working: (" . $areWorking . ")";
                        $selluz = new Cell($cellText, 0, "bluepalecell");

                        $desiredRow->SetCell($j, $selluz);
                    }
                }

                if($areWorking > 0 || $areStarting > 0) {

                }
            }
        }


        return $rows;
    }

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