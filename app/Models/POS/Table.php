<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = array('name', 'isBusy', 'slug');


    public function command()
    {
        return $this->hasMany('App\Models\POS\Command');
    }

}
