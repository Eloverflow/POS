<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Beer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'beers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'style', 'percent'];
}
