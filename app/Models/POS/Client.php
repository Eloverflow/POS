<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model {

    use LogsActivity;
    protected static $logAttributes = ['credit' , 'rfid_card_code', 'client_number'];

    protected $table = 'clients';

    protected $fillable = array('credit' , 'rfid_card_code', 'client_number', 'slug');

}
