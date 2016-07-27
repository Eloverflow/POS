<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Day_Availability extends Model
{
    //
    protected $table = 'day_availability';
    protected $fillable = ['availability_id', 'day', 'day_number', 'startTime', 'endTime'];

    public static function DeleteByDisponibilityId($id)
    {
        \DB::table('day_availability')->where('availability_id', '=', $id)->delete();
    }

}

