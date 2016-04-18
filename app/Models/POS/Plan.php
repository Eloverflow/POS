<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    protected $fillable = array('name', 'nbFloor');

    public static function getAll()
    {
        return  \DB::table('plans')
            ->select(\DB::raw('plans.id as idPlan,
            name,
            nbFloor,
            plans.created_at
            '))
            ->get();
    }
    public static function GetById($id)
    {
        return  \DB::table('plans')
            ->select(\DB::raw('plans.id as idPlan,
            name,
            nbFloor,
            plans.created_at
            '))
            ->where('id', '=', $id)
            ->first();
    }


}
