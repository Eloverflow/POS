<?php

namespace App\Models\Addons\Rfid;

use Illuminate\Database\Eloquent\Model;

class TableRfid extends Model
{
    protected $table = 'rfid_tables';


    protected $fillable = array('flash_card_hw_code','name','description');



    public function tableRfidBeer()
    {
        return $this->hasMany('App\Models\Addons\Rfid\TableRfidBeer', 'table_flash_card_hw_code', 'flash_card_hw_code');
    }

}
