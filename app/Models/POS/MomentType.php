<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class MomentType extends Model
{
    protected $table = 'moment_types';

    protected $fillable = ['name'];

    public static function  getAll() {
        return \DB::table('moment_types')
            ->select(\DB::raw('id, name'))
            ->get();
    }
}
