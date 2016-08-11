<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Separation extends Model {


    protected $table = 'separations';

    protected $fillable = array('noFloor', 'xPos', 'yPos','w', 'h', 'angle', 'plan_id');


    public function plan()
    {
        return $this->hasOne('App\Models\POS\Plan', 'id', 'plan_id');
    }

}
