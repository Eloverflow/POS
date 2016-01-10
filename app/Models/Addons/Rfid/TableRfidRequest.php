<?php

namespace App\Models\Addons\Rfid;

use Illuminate\Database\Eloquent\Model;

class TableRfidRequest extends Model
{
    protected $table = 'rfid_table_requests';


    protected $fillable = array('flash_card_hw_code', 'rfid_card_code');
}
