<?php

namespace App\Models\POS\Shared;

use Illuminate\Database\Eloquent\Model;

class Intersect
{
    protected $_number;
    protected $_isNearIntersect;

    public function __construct($text = "", $rowspan = 0)
    {
        $this->_text = $text;
        $this->_rowspan = $rowspan;
    }

    public function ToString()
    {
        return "<td>" . $this->_text . "</td>";
    }

}
