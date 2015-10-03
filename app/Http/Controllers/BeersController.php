<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Beer;

class BeersController extends Controller
{

    public  function index()
    {
        $beers = Beer::get();
        return view('beers.beers',compact('beers'));
    }

    public  function show($slug)
    {
        $beer = Beer::whereSlug($slug)->first();
        //$beer = Beer::find($id);
        return view('beers.show',compact('beer'));
    }
}