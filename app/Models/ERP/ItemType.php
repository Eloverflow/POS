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


    protected $fillable = array('type', 'fields_names');

    public function item()
    {
        return $this->hasMany('App\Models\ERP\Item');
    }
}
