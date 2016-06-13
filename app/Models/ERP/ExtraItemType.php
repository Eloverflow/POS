<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class ExtraItemType extends Model
{
    //
    protected $table = 'extra_item_types';
    protected $fillable = ['extra_id', 'item_type_id' ];

    public function extra()
    {
        return $this->belongsTo('App\Models\ERP\Extra', 'extra_id', 'id');
    }

    public function itemtype()
    {
        return $this->belongsTo('App\Models\ERP\ItemType', 'item_type_id', 'id');
    }
}
