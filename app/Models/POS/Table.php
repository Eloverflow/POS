<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivity;
use Spatie\Activitylog\LogsActivityInterface;

class Table extends Model implements LogsActivityInterface {

    use LogsActivity;

    protected $table = 'tables';

    protected $fillable = array('type', 'tblNumber', 'noFloor', 'xPos', 'yPos', 'angle', 'plan_id', 'status');


    public function command()
    {
        return $this->hasMany('App\Models\POS\Command');
    }

    public static function GetByPlanId($id)
    {
        return  \DB::table('tables')
            ->select(\DB::raw('tables.*'))
            ->where('tables.plan_id', '=', $id)
            ->orderBy('noFloor', 'asc')
            ->get();
    }

    public function plan()
    {
        return $this->hasOne('App\Models\POS\Plan', 'id', 'pland_id');
    }

    public function theplan()
    {
        return $this->hasOne('App\Models\POS\Plan', 'id', 'pland_id');
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
            $plan = $this->theplan;
            return '{"msg" : " table #' . $this->tblNumber  . ' - Status -> ' . $this->status  . ' - type : ' . $this->type . ' - floor #' . $this->noFloor . (!empty($plan) ? ' plan: ' .$plan['name'] : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'updated')
        {
            $plan = $this->theplan;
            return '{"msg" : " table #' . $this->tblNumber  . ' - Status -> ' . $this->status  . ' - type : ' . $this->type . ' - floor #' . $this->noFloor . (!empty($plan) ? ' plan: ' .$plan['name'] : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        if ($eventName == 'deleted')
        {
            $plan = $this->theplan;
            return '{"msg" : " table #' . $this->tblNumber  . ' - Status -> ' . $this->status  . ' - type : ' . $this->type . ' - floor #' . $this->noFloor . (!empty($plan) ? ' plan: ' .$plan['name'] : ''). ' ","row" : ' . $this . ',"type" : "' . $eventName . '"}';
        }

        return '';
    }
}
