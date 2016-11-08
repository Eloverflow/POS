<?php
/**
 * Created by PhpStorm.
 * User: maype
 * Date: 2016-11-07
 * Time: 13:28
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Validators\EmployeeValidators;

class ValidationExtensionServiceProvider extends ServiceProvider {

    public function register() {}

    public function boot() {
        /*$this->app->validator->resolver( function( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
            return new UserValidators( $translator, $data, $rules, $messages, $customAttributes );
        } );*/
        /*\Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
            $min = 1;
            return count($value) >= $min;
        });*/
    }

}
