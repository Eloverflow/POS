<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class FilterItem extends Model
{
    protected $table = 'filter_items';
    protected $fillable = ['filter_id', 'item_id' ];

    public function filter()
    {
        return $this->belongsTo('App\Models\POS\Filter', 'filter_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\ERP\Item', 'item_id', 'id');
    }
}
