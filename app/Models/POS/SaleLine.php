<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class SaleLine extends Model
{
    protected $table = 'sale_lines';

    protected $fillable = array('item_id', 'sale_id', 'cost', 'quantity', 'slug');


    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\POS\Sale');
    }
}
