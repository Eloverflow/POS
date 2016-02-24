<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = array('credit' , 'rfid_card_code', 'slug');

}
