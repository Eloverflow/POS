<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $table = 'filters';

    protected $fillable = ['name', 'description', 'type',  'status', 'importance', 'slug'];

    public function filter_item()
    {
        return $this->hasMany('App\Models\POS\FilterItem', 'id', 'filter_id');
    }

    public function filter_item_type()
    {
        return $this->hasMany('App\Models\POS\FilterItemType', 'id', 'filter_id');
    }
}
