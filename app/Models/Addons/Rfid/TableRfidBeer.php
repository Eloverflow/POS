<?php

namespace App\Models\Addons\Rfid;

use Illuminate\Database\Eloquent\Model;

class TableRfidBeer extends Model
{
    protected $table = 'rfid_table_beers';


    protected $fillable = array('flash_card_hw_code', 'img_url');


    public function tableRfid()
    {
        return $this->belongsTo('App\Models\Addons\Rfid\TableRfid', 'table_flash_card_hw_code', 'flash_card_hw_code');
    }


}
