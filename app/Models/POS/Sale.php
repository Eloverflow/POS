<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = array('client_id' , 'sale_number', 'total', 'cancelled', 'slug');


    public function client()
    {
        return $this->hasOne('App\Models\POS\Client', 'id', 'client_id');
    }

    public function saleline()
    {
        return $this->hasMany('App\Models\POS\SaleLine');
    }
}
