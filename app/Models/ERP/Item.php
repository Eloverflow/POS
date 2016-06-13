<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';

    protected $fillable = array('name' ,'description', 'item_type_id', 'img_id', 'slug', 'custom_fields_array', 'size_prices_array');

    public function itemtype()
    {
        return $this->hasOne('App\Models\ERP\ItemType', 'id', 'item_type_id');
    }
    public function inventory()
    {
        return $this->belongsTo('App\Models\ERP\Inventory');
    }
    public function extra_item()
    {
        return $this->hasMany('App\Models\ERP\ExtraItem', 'id', 'item_id');
    }
}


