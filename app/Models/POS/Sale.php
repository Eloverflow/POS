<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = array('command_id' , 'sale_number', 'total', 'cancelled', 'slug');


    public function command()
    {
        return $this->hasOne('App\Models\POS\Command', 'id', 'command_id');
    }

    public function saleline()
    {
        return $this->hasMany('App\Models\POS\SaleLine');
    }
}
