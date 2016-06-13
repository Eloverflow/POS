<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{


    protected $table = 'extras';

    protected $fillable = ['name', 'desc', 'effect', 'value', 'status', 'slug'];

    public function extra_item()
    {
        return $this->hasMany('App\Models\ERP\ExtraItem', 'id', 'extra_id');
    }

    public function extra_item_type()
    {
        return $this->hasMany('App\Models\ERP\ExtraItemType', 'id', 'extra_id');
    }
}


