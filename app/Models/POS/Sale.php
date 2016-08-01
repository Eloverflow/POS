<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sale extends Model {

    use LogsActivity;
    protected $table = 'sales';

    protected $fillable = array('sale_number', 'cancelled', 'status', 'total', 'taxes', 'subTotal', 'paiement_type', 'extras', 'slug');

    protected static $logAttributes = ['sale_number', 'cancelled', 'total', 'taxes', 'subTotal', 'paiement_type', 'extras',];


    public function saleline()
    {
        return $this->hasMany('App\Models\POS\SaleLine');
    }

    /**
     * Get the message that needs to be logged for the given event name.
     *
     * @param string $eventName
     * @return string
     */
    /*public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return '{"msg" : " sale #' . $this->sale_number  . ' - Status -> ' . $this->status . ' - Is cancelled : ' . $this->cancelled . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : " sale #' . $this->sale_number  . ' - Status -> ' . $this->status . ' - Is cancelled : ' . $this->cancelled . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : " sale #' . $this->sale_number  . ' - Status -> ' . $this->status . ' - Is cancelled : ' . $this->cancelled . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/
}
