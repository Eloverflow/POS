<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = array('','type', 'tblNumber', 'noFloor', 'xPos', 'yPos', 'angle', 'plan_id', 'status');


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
}
