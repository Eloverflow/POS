<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

class Command extends Model{
    
    use LogsActivity;
    //use Searchable;
    protected static $logAttributes = ['table_id', 'client_id', 'command_number', 'notes', 'status', 'extras'];

    protected $table = 'commands';

    protected $fillable = array('table_id', 'client_id', 'command_number', 'notes', 'status', 'extras', 'slug');


    public function client()
    {
        return $this->hasOne('App\Models\POS\Client', 'id', 'client_id');
    }

    public function table()
    {
        return $this->hasOne('App\Models\POS\Table', 'id', 'table_id');
    }

    public function tables()
    {
        return $this->hasOne('App\Models\POS\Table', 'id', 'table_id');
    }

    public function commandline()
    {
        return $this->hasMany('App\Models\POS\CommandLine', 'command_id', 'id');
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
            return '{"msg" : "Command #' . $this->command_number  . ' - client : ' . $this->client_id . ' of table #' . $this->tables->tblNumber . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            return '{"msg" : "Command #' . $this->command_number  . ' - client : ' . $this->client_id . ' of table #' . $this->tables->tblNumber . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            return '{"msg" : "Command #' . $this->command_number  . ' - client : ' . $this->client_id . ' of table #' . $this->tables->tblNumber . ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }*/
}
