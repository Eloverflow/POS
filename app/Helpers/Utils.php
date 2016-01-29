<?php
namespace App\Helpers;
use App\Models\POS\Disponibility;
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
                $DTET = new \DateTime($diposJour[$k]->endTime);
                $EndTime = $DTET->format('H');
                $diff = $EndTime - $StartTime;
                if (($Hour < $EndTime && $Hour > $StartTime) || $EndTime == $Hour) {
                    $newInters = new Intersect($j, $Hour);
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
                $DTET = new \DateTime($diposJour[$k]->endTime);
                $EndTime = $DTET->format('H');
                $diff = $EndTime - $StartTime;
                if ($StartTime == $Hour) {
                    $newInters = new Intersect($j, $Hour);
                    $countIntersects = $countIntersects + 1;
                    $Intersects[] = $newInters;
                }
            }
        }
        return $Intersects ;
    }

    static public function CalculateHorizontalIntersect($weekDispos, $LeftRight, $DayNumber, $Hour)
    {
        $countIntersects = 0;
        $isIntersect = false;

        if($LeftRight == "Left") {
            $JIncrement = 0;
            $DDayNumber = $DayNumber;
        }
        else {
            $JIncrement = $DayNumber + 1;
            $DDayNumber = 7;
        }

        for ($j = $JIncrement; $j < $DDayNumber; $j++) {
            $diposJour = $weekDispos[$j];
            for ($k = 0; $k < count($diposJour); $k++) {
                $DTST = new \DateTime($diposJour[$k]->startTime);
                $StartTime = $DTST->format('H');
                $DTET = new \DateTime($diposJour[$k]->endTime);
                $EndTime = $DTET->format('H');
                $diff = $EndTime - $StartTime;
                if ($StartTime == $Hour || ($Hour < $EndTime && $Hour > $StartTime )) {
                    $countIntersects = $countIntersects +1;
                    if(($DayNumber - 1) == $j)
                    {
                        $isIntersect = true;
                    }
                    else if(($DayNumber + 1) == $j){
                        $isIntersect = true;
                    }
                } else {

                }
            }

        }

        if ($isIntersect == true) {

            return $countIntersects . "|" . 1;
        }
        else
        {
            return $countIntersects . "|" . 0;
        }
    }


    static public function GenerateDisponibilityTable($idUser)
    {
        $Cells = null;

        $WeekDisponibilities = array(
            0 => Disponibility::GetDayDisponibilities($idUser, 0),
            1 => Disponibility::GetDayDisponibilities($idUser, 1),
            2 => Disponibility::GetDayDisponibilities($idUser, 2),
            3 => Disponibility::GetDayDisponibilities($idUser, 3),
            4 => Disponibility::GetDayDisponibilities($idUser, 4),
            5 => Disponibility::GetDayDisponibilities($idUser, 5),
            6 => Disponibility::GetDayDisponibilities($idUser, 6),
        );

        $BlankTable = Utils::GetBlankTable("haha");
        $arrangedTable = Utils::arrangeRows($BlankTable, $WeekDisponibilities);

        $count = 0;
        $rows = null;
        while($count < count($arrangedTable))
        {
            $row = $arrangedTable[$count];
            $rows[] = "<tr><td>" . ($count + 1) . "</td>" . $row->ToString() . "</tr>";
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
        $Cells = array();


        $theIntersect = Utils::CalculateIntersects(16,$weekDispos);

        for($i = 1; $i < 24; $i++)
        {
            $starts = Utils::CalculateStarts($i,$weekDispos);
            $curRow = $rows[$i -1];

            for($j = 0; $j < count($starts); $j++)
            {
                $start = $starts[$j];
                var_dump($start);
                //var_dump($start->GetDayNumber());
                $selluz = new Cell("Start $i");
                $dayNumb = $start->GetDayNumber();

                $curRow->SetCell($dayNumb, $selluz);
            }
        }

        echo count($theIntersect) . " - " . count($starts);

        /*}*/

        //unset($Cells[1]);

        //var_dump($Cells[1]);
        //$Cells = array_values($Cells);
        //array_push($Cells, new Cell("moufta"));

        //$Row = new Row($Cells);
        //$rows[1] = $Row;
        return $rows;
    }
}