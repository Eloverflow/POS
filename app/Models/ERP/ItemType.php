<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'item_types';


    protected $fillable = array('type', 'field_names', 'size_names', 'quantity_reducer', 'slug');

    public function item()
    {
        return $this->hasMany('App\Models\ERP\Item');
    }

    public function extra_item_type()
    {
        return $this->hasMany('App\Models\ERP\ExtraItemType', 'id', 'item_type_id');
    }
}
