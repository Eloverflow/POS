<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $table = 'commands';

    protected $fillable = array('table_id', 'client_id', 'command_number', 'notes', 'total', 'status', 'slug');


    public function client()
    {
        return $this->hasOne('App\Models\POS\Client', 'id', 'client_id');
    }

    public function table()
    {
        return $this->hasOne('App\Models\POS\Table', 'id', 'table_id');
    }

    public function commandline()
    {
        return $this->hasMany('App\Models\POS\CommandLine');
    }
}
