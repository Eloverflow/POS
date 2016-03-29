<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class CommandLine extends Model
{
    protected $table = 'command_lines';

    protected $fillable = array('item_id', 'sale_id', 'cost', 'quantity', 'slug');


    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function command()
    {
        return $this->belongsTo('App\Models\POS\Sale');
    }
}
