<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class FilterItemType extends Model
{
    protected $table = 'filter_item_types';
    protected $fillable = ['filter_id', 'item_type_id' ];

    public function filter()
    {
        return $this->belongsTo('App\Models\POS\filter', 'filter_id', 'id');
    }

    public function itemtype()
    {
        return $this->belongsTo('App\Models\ERP\ItemType', 'item_type_id', 'id');
    }
}
