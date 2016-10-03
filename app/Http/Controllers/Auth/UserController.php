<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    public function update(){
       return  view('auth.update');
    }

    public function forgotPass(){
       return  view('auth.passwords.email');
    }

    public function updatePassword(){

        $rules = array(
            'now_password'          => 'required|min:8',
            'password'              => 'required|min:8|confirmed|different:now_password',
            'password_confirmation' => 'required|min:8',
        );
        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = Validator::make(Input::all(), $rules, $message);
        if($validation -> fails())
        {
            return Redirect::to('/user/password/update')->withErrors($validation)
                ->withInput();
        }
        else {
            $now_password   = Input::get('now_password');
            if(Hash::check($now_password, Auth::user()->password)){
                $user = Auth::user();
                $user->password = \Hash::make(Input::get('password'));
                $user->save();
                return Redirect::to('/')->withSuccess('Password successfully updated !');
            }
            else{
                return Redirect::to('/user/password/update')->withErrors('Passwords dont match !');
            }

        }
    }

}
