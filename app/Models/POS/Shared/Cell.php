<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Cell
{
    protected $_text;
    protected $_rowspan;
    protected $_classname;
    protected  $_dataEmployees;

    public function __construct($text = "", $rowspan = 0, $classname = "", $dataEmployees = array())
    {
        $this->_text = $text;
        $this->_rowspan = $rowspan;
        $this->_classname = $classname;
        $this->_dataEmployees = $dataEmployees;
    }


    public function ToString()
    {
        return "<td rowspan=" . $this->_rowspan . " class=\"" . $this->_classname . "\" data-Employees=\"" . json_encode($this->_dataEmployees) . "\">" . $this->_text . "</td>";
    }

    public function setTxt($txt){
        $this->_text = $txt;
    }

    public function getTxt(){
        return $this->_text;
    }

    public function AddEmployee($employee){
        $this->_dataEmployees = array_merge($this->_dataEmployees, $employee);
    }

}

class ScheduleCell Extends Cell
{

    protected $_arestarting;
    protected $_areworking;

    public function __construct($text = "", $rowspan = 0, $classname = "", $areStarting = 0, $areWorking = 0)
    {
        parent::__construct($text, $rowspan, $classname);

        $this->_arestarting = $areStarting;
        $this->_areworking = $areWorking;
    }

    public function ToScheduleCell()
    {
        return "Starting: (" . $this->_arestarting . ") <br />Working: (" . $this->_areworking . ")";
    }

}