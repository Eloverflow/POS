<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\Beer;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class ItemsController extends Controller
{

    public  function index()
    {
        $beers = Beer::get();
        $columns = array('id','brand', 'name', 'style', 'percent' );
        return view('beers.beers',compact('beers', 'columns'));
    }

    public  function edit($slug)
    {
        $columns = array('brand', 'name', 'style', 'percent', 'description' );
        $beer = Beer::whereSlug($slug)->first();
        $next_beer = Beer::findOrNew(($beer->id)+1);
        $previous_beer = Beer::findOrNew(($beer->id)-1);
        return view('beers.show',compact('beer','columns','next_beer','previous_beer'));
    }



    public  function update($slug, Request $request)
    {
        $beer = Beer::whereSlug($slug)->first();

        $input = $request->all();

        $beer->update($input);


        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}