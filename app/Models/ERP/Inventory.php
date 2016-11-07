<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventories';

    protected $fillable = array('quantity' ,'item_id', 'item_size', 'slug');

    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }
}
