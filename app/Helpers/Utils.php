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
                if (($Hour < $EndTime && $Hour > $StartTime) ) {
                    $newInters = new Intersect($j, $Hour, $EndTime, $StartMin, $EndMin);
                    $countIntersects = $countIntersects + 1;
                    $Intersects[] = $newInters;
                }
            }
        }
        return $Intersects ;
    }


    static public function CalculateStarts($Hour, $weekDispos)
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
                if ($StartTime == $Hour) {
                    $newInters = new Intersect($j, $Hour, $EndTime, $StartMin, $EndMin);
                    $countIntersects = $countIntersects + 1;
                    $Intersects[] = $newInters;
                }
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
            $starts = Utils::CalculateStarts($i,$weekDispos);
            $normalIntersects = Utils::CalculateIntersects($i,$weekDispos);
            $curRow = $rows[$i -1];

            //var_dump($starts);
            for($j = 0; $j < count($starts); $j++)
            {
                $start = $starts[$j];

                $rowspan = $start->GetEndTime() - $start->GetStartTime();
                $formattedStartTime = "";
                $formattedEndTime = "";

                if($start->GetStartTime() < 10)
                {
                    $formattedStartTime = "0" . $start->GetStartTime() . ":" . $start->GetStartMin();
                } else {
                    $formattedStartTime = $start->GetStartTime() . ":" . $start->GetStartMin();
                }
                if($start->GetEndTime() < 10)
                {
                    $formattedEndTime = $start->GetEndTime() . ":" . $start->GetEndMin();
                } else {
                    $formattedEndTime = $start->GetEndTime() . ":" . $start->GetEndMin();
                }

                $cellText = $formattedStartTime . " <br />To<br /> " . $formattedEndTime;
                $selluz = new Cell($cellText, $rowspan, "bluepalecell");
                $dayNumb = $start->GetDayNumber();

                $curRow->SetCell($dayNumb, $selluz);
            }
            for($k = 0; $k < count($normalIntersects); $k++)
            {
                $nIntersect = $normalIntersects[$k];
                //var_dump($nIntersect);
                //var_dump($start->GetDayNumber());

                $dayNumb = $nIntersect->GetDayNumber();

                $curRow->RemoveCell($dayNumb);
            }
        }

        return $rows;
    }


    static public function arrangeScheduleRows($rows, $weekDispos)
    {



        //return $rows;
    }

}