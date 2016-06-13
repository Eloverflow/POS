<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class ExtraItem extends Model
{

    protected $table = 'extra_items';
    protected $fillable = ['extra_id', 'item_id' ];

    public function extra()
    {
        return $this->belongsTo('App\Models\ERP\Extra', 'extra_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\ERP\Item', 'item_id', 'id');
    }
}
