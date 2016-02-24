<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    //
    protected $fillable = ['inout', 'employee_id', 'created_at'];

    public static function GetLatestPunch($idEmployee)
    {
        return \DB::table('punches')
            ->join('employees', 'punches.employee_id', '=', 'employees.id')
            ->select(\DB::raw('punches.inout'))
            ->where('punches.employee_id', '=', $idEmployee)
            ->orderBy('punches.created_at', 'desc')
            ->first();
    }


    public static function GetByEmployeeId($id){
        return \DB::table('punches')
                ->select(\DB::raw('punches.id, punches.inout, DATE_FORMAT(punches.created_at, \'%h:%i %p\') as time, DATE_FORMAT(punches.created_at, \'%m-%d-%Y\') as date'))
                ->where('punches.employee_id', '=', $id)
                ->orderBy('punches.created_at', 'desc')
                ->get();
    }
}
