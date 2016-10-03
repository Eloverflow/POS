<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model  {
    use LogsActivity;
    protected static $logAttributes = ['name' ,'description', 'item_type_id', 'img_id', 'slug', 'custom_fields_array', 'size_prices_array'];

    protected $table = 'items';

    protected $fillable = array('name' ,'description', 'item_type_id', 'img_id', 'slug', 'custom_fields_array', 'size_prices_array');

    public function itemtype()
    {
        return $this->hasOne('App\Models\ERP\ItemType', 'id', 'item_type_id');
    }
    public function inventory()
    {
        return $this->belongsTo('App\Models\ERP\Inventory');
    }
    public function extra_item()
    {
        return $this->hasMany('App\Models\ERP\ExtraItem', 'id', 'item_id');
    }

    /**
     * Get the message that needs to be logged for the given event name.
     *
     * @param string $eventName
     * @return string
     */
   /* public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return '{"msg" : "Item #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : "Item #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : "Item #' . $this->client_number  . ' - Credit -> ' . $this->credit  . (!empty($this->rfid_card_code) ?  ' - rfid_card_code: ' . $this->rfid_card_code : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/
}


