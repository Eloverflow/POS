<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = array('taxes', 'plan_id', 'use_time_24', 'language', 'timezone', 'daylight', 'ipaddress', 'use_email');

    protected $casts = [
        'taxes' => 'json'
    ];

    /* public function UserRole()
        {*/
    /*Will belong to administrators*/
    /*    return $this->belongsTo('App\Models\Auth\UserRole');
    }*/
}
