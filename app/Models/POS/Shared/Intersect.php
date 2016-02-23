<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Intersect
{
    protected $_type;
    protected $_dayNumber;
    protected $_realStartTime;
    protected $_realEndTime;
    protected $_startTime;
    protected $_endTime;
    protected $_startMin;
    protected $_endMin;

    public function __construct($type = "", $dayNumber = 0, $startTime = 0, $endTime = 0, $startMin = 0, $endMin = 0)
    {
        $this->_type = $type;
        $this->_dayNumber = $dayNumber;
        $this->_startTime = $startTime;
        $this->_endTime = $endTime;
        $this->_startMin = $startMin;
        $this->_endMin = $endMin;
    }

    public function GetRealStartTime()
    {
        return $this->_realStartTime;
    }

    public function SetRealStartTime($realStartTime)
    {
        $this->_realStartTime = $realStartTime;
    }

    public function GetRealEndTime()
    {
        return $this->_realEndTime;
    }

    public function SetRealEndTime($realEndTime)
    {
        $this->_realEndTime = $realEndTime;
    }

    public function GetType()
    {
        return $this->_type;
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
