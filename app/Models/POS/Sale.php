<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = array('table_id' , 'sale_number', 'total', 'cancelled', 'slug');


    public function table()
    {
        return $this->hasOne('App\Models\POS\Table', 'id', 'table_id');
    }

    public function saleline()
    {
        return $this->hasMany('App\Models\POS\SaleLine');
    }
}
