<?php
namespace App\Helpers;
use App\Models\POS\Disponibility;
use App\Models\POS\Schedule;
use App\Models\POS\Shared\Cell;
use App\Models\POS\Shared\Row;
use App\Models\POS\Shared\Intersect;

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

                //if ($EndTime > $StartTime) {
                    if (($Hour < $EndTime && $Hour > $StartTime)) {
                        if ($StartTime != 0) {
                            $newInters = new Intersect("current", $j, $Hour, $EndTime, $StartMin, $EndMin);
                        } else {
                            //$newInters = new Intersect("current", $j, $Hour, $EndTime, $StartMin, $EndMin);
                        }

                        $countIntersects = $countIntersects + 1;
                        $Intersects[] = $newInters;
                    }
                    if ($StartTime == $Hour) {
                        if($EndTime == 0) {
                            $correctEndTime = 24;
                        }  else if($EndTime < $StartTime) {
                            $correctEndTime = 25;
                            if($EndTime > 1)
                            {
                                $newInters = new Intersect("start", $j + 1, 1, $EndTime, 0, 0);
                                $Intersects[] = $newInters;
                            }
                        } else {
                            $correctEndTime = $EndTime;
                        }
                        $newInters = new Intersect("start", $j, $Hour, $correctEndTime, $StartMin, $EndMin);
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
        $arrangedTable = Utils::arrangeScheduleRows($BlankTable, $WeekDisponibilities);

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


                if($intersect->GetType() == "start") {
                    if($intersect->GetEndTime() > $intersect->GetStartTime()) {
                        $rowspan = $intersect->GetEndTime() - $intersect->GetStartTime();
                    } else {
                        $rowspan = 25 - $intersect->GetStartTime();
                    }


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

                    $cellText = $formattedStartTime . " <br />To<br /> " . $formattedEndTime;
                    $selluz = new Cell($cellText, $rowspan, "bluepalecell");
                    $dayNumb = $intersect->GetDayNumber();

                    $curRow->SetCell($dayNumb, $selluz);
                } else if($intersect->GetType() == "current") {
                    $dayNumb = $intersect->GetDayNumber();

                    $curRow->RemoveCell($dayNumb);
                }
            }
        }

        return $rows;
    }


    static public function arrangeScheduleRows($rows, $weekDispos)
    {
        for($i = 1; $i < 24; $i++)
        {
            $intersects = Utils::CalculateIntersects($i,$weekDispos);
            $curRow = $rows[$i -1];

            for($j = 0; $j < 7; $j++)
            {

                $areWorking = 0;
                $areStarting = 0;
                for($k = 0; $k < count($intersects); $k++) {
                    if ($intersects[$k]->GetType() == "start" && $intersects[$k]->GetDayNumber() == $j) {
                        $areStarting = $areStarting + 1;
                        $areWorking = $areWorking + 1;
                    } else if ($intersects[$k]->GetType() == "current" && $intersects[$k]->GetDayNumber() == $j) {
                        $areWorking = $areWorking + 1;
                    }
                }

                if($areWorking > 0 || $areStarting > 0) {
                    $cellText = "Starting: (" . $areStarting . ") <br />Working: (" . $areWorking . ")";
                    $selluz = new Cell($cellText, 0, "bluepalecell");

                    $curRow->SetCell($j, $selluz);
                }
            }
        }


        return $rows;
    }

}