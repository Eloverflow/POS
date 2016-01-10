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

    protected $fillable = array('item_id' ,'order_id', 'quantity');
}
