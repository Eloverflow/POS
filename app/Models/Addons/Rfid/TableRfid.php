<?php

namespace App\Models\Addons\Rfid;

use Illuminate\Database\Eloquent\Model;

class TableRfid extends Model
{
    protected $table = 'rfid_tables';


    protected $fillable = array('flash_card_hw_code','name','description','beer1_item_id', 'beer2_item_id');


    public function beer1()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'beer1_item_id');
    }

    public function beer2()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'beer2_item_id');
    }

}
