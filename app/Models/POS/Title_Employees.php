<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class Title_Employees extends Model
{
    //
    protected $table = 'title_employees';
    protected $fillable = ['employee_id', 'employee_titles_id'];
}
