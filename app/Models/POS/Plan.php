<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = array('name', 'nbFloor', 'wallPoints');

    public static function getAll()
    {
        return  \DB::table('plans')
            ->join('tables', 'plans.id', '=', 'tables.plan_id')
            ->select(\DB::raw('plans.id as idPlan,
            name,
            nbFloor,
            wallPoints,
            count(tables.id) as nbTable,
            plans.created_at
            '))
            //->where('id', '=', $id)
            ->get();

    }

    public static function GetById($id)
    {
        return  \DB::table('plans')
            ->select(\DB::raw('plans.id as idPlan,
            name,
            nbFloor,
            wallPoints,
            plans.created_at
            '))
            ->where('id', '=', $id)
            ->first();
    }

    public function table()
    {
        return $this->hasMany('App\Models\POS\Table');
    }



}
