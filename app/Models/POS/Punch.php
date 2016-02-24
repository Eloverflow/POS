<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    //
    protected $fillable = ['inout', 'employee_id'];

    public static function GetLatestPunch($idEmployee)
    {
        return \DB::table('punches')
            ->join('employees', 'punches.employee_id', '=', 'employees.id')
            ->where('punches.employee_id', '=', $idEmployee)
            ->select(\DB::raw('punches.inout'))
            ->orderBy('punches.created_at', 'desc')
            ->first();
    }


    public static function GetByEmployeeId($id){
        \DB::table('punches')
            ->where('punches.employee_id', '=', $id)
            ->select(\DB::raw('punches.inout, punches.created_at'))
            ->orderBy('punches.created_at', 'desc')
            ->get();
    }
}
