<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SaleLine extends Model {

    use LogsActivity;

    protected $table = 'sale_lines';

    protected $fillable = array('command_id', 'command_line_id' , 'item_id', 'sale_id', 'cost', 'quantity', 'size', 'taxes', 'extras', 'slug');

    public function command()
    {
        return $this->hasOne('App\Models\POS\Command', 'id', 'command_id');
    }

    public function commandline()
    {
        return $this->hasOne('App\Models\POS\CommandLine', 'id', 'command_line_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\POS\Sale');
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
            return '{"msg" : "Sale Line '  . ' - Status -> ' . $this->status . ' of sale #' . $this->sale->sale_number  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : "Sale Line '  . ' - Status -> ' . $this->status . ' of sale #' . $this->sale->sale_number  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : "Sale Line '  . ' - Status -> ' . $this->status . ' of sale #' . $this->sale->sale_number  . ' - item : ' . $this->size . ' of ' . $this->item->name .' X ' . $this->quantity . ' - cost: ' . $this->cost . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/
}
