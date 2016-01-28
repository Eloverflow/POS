<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Row
{
    protected $_cells = array();

    public function __construct($cells)
    {
        for($j = 0; $j < count($cells); $j++)
        {
            array_push($this->_cells, $cells[$j]);
        }
        //array_replace($this->_cells, $cells);
    }

    public function GetCell($ind)
    {
        return $this->_cells[$ind];
    }

    public function SetCell($ind, $cell)
    {
        $this->_cells[$ind] = $cell;
    }

    public function RemoveCell($ind)
    {
        $this->_cells[$ind] = null;
    }

    public function ToString()
    {
        $cellCompiled = "";
        for($i = 0; $i < count($this->_cells); $i++)
        {
            $cellCompiled = $cellCompiled . $this->_cells[$i]->ToString();
        }
        return  $cellCompiled;
    }

}
