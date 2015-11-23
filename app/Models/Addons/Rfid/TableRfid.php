<?php

namespace App\Models\Addons\Rfid;

use Illuminate\Database\Eloquent\Model;

class TableRfid extends Model
{
    protected $table = 'rfid_tables';


    protected $fillable = array('flash_card_hw_code','name','description');
}
