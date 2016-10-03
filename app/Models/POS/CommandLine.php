<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CommandLine extends Model {

    use LogsActivity;
    protected static $logAttributes = ['command_id', 'status', 'item_id', 'sale_id', 'extras', 'service_number', 'notes', 'size', 'cost', 'quantity'];

    protected $table = 'command_lines';

    protected $fillable = array('command_id', 'status', 'item_id', 'sale_id', 'extras', 'service_number', 'notes', 'size', 'cost', 'quantity', 'slug');


    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function command()
    {
        return $this->belongsTo('App\Models\POS\Command', 'id', 'command_id');
    }
    public function sale()
    {
        return $this->belongsTo('App\Models\POS\Sale', 'id', 'sale_id');
    }

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
            return '{"msg" : "Command Line '  . ' - Status -> ' . $this->status . ' of command #' . $this->command_id  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : "Command Line '  . ' - Status -> ' . $this->status . ' of command #' . $this->command_id  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : "Command Line '  . ' - Status -> ' . $this->status . ' of command #' . $this->command_id  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/
}
