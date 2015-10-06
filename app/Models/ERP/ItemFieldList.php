<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class ItemFieldList extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'item_field_lists';

    public function item()
    {
        return $this->belongsTo('App\Models\ERP\Item');
    }
}
