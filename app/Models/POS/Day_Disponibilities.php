<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Day_Disponibilities extends Model
{
    //
    protected $table = 'day_disponibilities';
    protected $fillable = ['disponibility_id', 'day', 'day_number', 'startTime', 'endTime'];

    public static function DeleteByDisponibilityId($id)
    {
        \DB::table('day_disponibilities')->where('disponibility_id', '=', $id)->delete();
    }

}

