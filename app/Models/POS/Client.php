<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    protected $table = 'clients';

    protected $fillable = array('credit' , 'rfid_card_code', 'client_number', 'slug');

    /**
     * Get the message that needs to be logged for the given event name.
     *
     * @param string $eventName
     * @return string
     *//*
    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return '{"msg" : "Client #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : "Client #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : "Client #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/

}
