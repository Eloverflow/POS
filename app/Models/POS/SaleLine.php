<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class SaleLine extends Model
{
    protected $table = 'sale_lines';

    protected $fillable = array('command_id', 'command_line_id' , 'item_id', 'sale_id', 'cost', 'quantity', 'size', 'taxes', 'slug');

    public function command()
    {
        return $this->hasOne('App\Models\POS\Command', 'id', 'command_id');
    }

    public function commandline()
    {
        return $this->hasOne('App\Models\POS\CommandLine', 'id', 'command_line_id');
    }

    public function item()
    {
        return $this->hasOne('App\Models\ERP\Item', 'id', 'item_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\POS\Sale');
    }
}
