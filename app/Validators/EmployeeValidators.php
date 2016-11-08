<?php
/**
 * Created by PhpStorm.
 * User: maype
 * Date: 2016-11-07
 * Time: 11:48
 */

namespace App\Validators;

use Illuminate\Validation\Validator;


class EmployeeValidators extends Validator {

    public function foo($field, $value, $parameters){
        $min = 1;
        return count($value) >= $min;
    }
    
}