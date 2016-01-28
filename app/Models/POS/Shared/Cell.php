<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Cell
{
    protected $_text;
    protected $_rowspan;
    protected $_classname;

    public function __construct($text = "", $rowspan = 0, $clasname = "")
    {
        $this->_text = $text;
        $this->_rowspan = $rowspan;
        $this->_classname = $clasname;
    }

    public function ToString()
    {
        return "<td class=\"" . $this->_classname . "\">" . $this->_text . "</td>";
    }

    public function getTxt(){
        return $this->_text;
    }

}
