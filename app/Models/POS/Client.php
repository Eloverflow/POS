<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';

    protected $fillable = array('credit' , 'rfid_card_code');

}
