<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class SuppliersController extends Controller
{

    public  function index()
    {
        $suppliers = Beer::get();
        return '';
    }
}