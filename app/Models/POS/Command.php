<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivity;
use Spatie\Activitylog\LogsActivityInterface;

class Command extends Model implements LogsActivityInterface {

    use LogsActivity;

    protected $table = 'commands';

    protected $fillable = array('table_id', 'client_id', 'command_number', 'notes', 'total', 'taxes', 'subTotal', 'status', 'slug');


    public function client()
    {
        return $this->hasOne('App\Models\POS\Client', 'id', 'client_id');
    }

    public function table()
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
     */
    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Command number "' . $this->command_number . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Command number "' . $this->command_number . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Command number "' . $this->command_number . '" was deleted';
        }

        return '';
    }
}
