<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = array('item_id', 'client_id' , 'sale_number', 'cost', 'quantity', 'slug');


    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function client()
    {
        return $this->hasOne('App\Models\POS\Client', 'id', 'client_id');
    }
}
