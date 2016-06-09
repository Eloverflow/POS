<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = array('sale_number', 'cancelled', 'total', 'taxes', 'subTotal', 'slug');


    public function saleline()
    {
        return $this->hasMany('App\Models\POS\SaleLine');
    }
}
