<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\Beer;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class InventoriesController extends Controller
{

    public  function index()
    {
        $beers = Beer::get();
        return '';
    }
}