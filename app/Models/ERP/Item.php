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

    protected $fillable = array('name' ,'description', 'item_type_id', 'img_id', 'slug', 'customField1', 'customField2', 'customField3', 'customField4', 'customField5', 'customField6', 'customField7', 'customField8', 'customField9', 'customField10');

    public function itemtype()
    {
        return $this->hasOne('App\Models\ERP\ItemType', 'id', 'item_type_id');
    }
    public function inventory()
    {
        return $this->belongsTo('App\Models\ERP\Inventory');
    }
}


