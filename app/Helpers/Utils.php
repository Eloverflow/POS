<?php
namespace App\Helpers;
use App\Models\POS\Disponibility;
use App\Models\POS\Shared\Cell;
use App\Models\POS\Shared\Row;

/**
 * Created by PhpStorm.
 * User: Maype-IsaelBlais
 * Date: 2016-01-26
 * Time: 12:03
*/

/* shdyhsyhsys */

class Utils
{
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
        $arrangedTable = Utils::arrangeRows($BlankTable);

        $count = 0;
        $rows = null;
        while($count < count($arrangedTable))
        {
            $row = $arrangedTable[$count];
            $rows[] = "<tr><td>$count</td>" . $row->ToString() . "</tr>";
            $count += 1;
        }

        return $rows;
    }

    static public function GetBlankTable($message)
    {
        $Rows = null;
        for($i = 1; $i <= 24; $i++) {

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

    static public function arrangeRows($rows)
    {
        $Cells = array();

        /*for($k = 0; $k < 7; $k++)
        {*/
        $k = 0;
        while($k < 7){
            if ($k == 5) {
                /*array_push($Cells, new Cell("crisssss"));*/
                $Cells[$k] = new Cell("crisssss");
            } else {
                $Cells[$k] = new Cell("vagina");
                /*array_push($Cells, new Cell("vagina"));*/
            }
            $k++;
            echo $k;
        }

        foreach($Cells as $cell){
            echo $cell->getTxt();
        }
        /*}*/

        //unset($Cells[1]);
        //$Cells[1] = new Cell("vagina");
        //var_dump($Cells[1]);
        //$Cells = array_values($Cells);
        //array_push($Cells, new Cell("moufta"));

        $Row = new Row($Cells);
        $rows[1] = $Row;
        return $rows;
    }
}