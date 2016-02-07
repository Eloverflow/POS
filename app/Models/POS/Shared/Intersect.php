<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Intersect
{
    protected $_dayNumber;
    protected $_startTime;
    protected$_endTime;
    protected $_startMin;
    protected$_endMin;

    public function __construct($dayNumber = 0, $startTime = 0, $endTime = 0, $startMin = 0, $endMin = 0)
    {
        $this->_dayNumber = $dayNumber;
        $this->_startTime = $startTime;
        $this->_endTime = $endTime;
        $this->_startMin = $startMin;
        $this->_endMin = $endMin;
    }

    public function GetDayNumber()
    {
        return $this->_dayNumber;
    }

    public function GetStartTime()
    {
        return $this->_startTime;
    }

    public function GetEndTime()
    {
        return $this->_endTime;
    }

    public function GetStartMin()
    {
        return $this->_startMin;
    }

    public function GetEndMin()
    {
        return $this->_endMin;
    }

    public function ToString()
    {
        return "<td>" . $this->_text . "</td>";
    }

}
