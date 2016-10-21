<?php

namespace App\Models\ERP;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Extra extends Model
{
    //use Searchable;

    protected $table = 'extras';

    protected $fillable = ['name', 'description', 'effect', 'value', 'status', 'slug', 'avail_for_command'];

    public function extra_item()
    {
        return $this->hasMany('App\Models\ERP\ExtraItem', 'id', 'extra_id');
    }

    public function extra_item_type()
    {
        return $this->hasMany('App\Models\ERP\ExtraItemType', 'id', 'extra_id');
    }
}


