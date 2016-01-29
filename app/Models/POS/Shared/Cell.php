<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Cell
{
    protected $_text;
    protected $_rowspan;
    protected $_classname;

    public function __construct($text = "", $rowspan = 0, $classname = "")
    {
        $this->_text = $text;
        $this->_rowspan = $rowspan;
        $this->_classname = $classname;
    }

    public function ToString()
    {
        return "<td rowspan=" . $this->_rowspan . " class=\"" . $this->_classname . "\">" . $this->_text . "</td>";
    }

    public function getTxt(){
        return $this->_text;
    }

}
