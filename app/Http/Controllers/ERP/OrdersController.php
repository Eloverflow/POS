<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class OrdersController extends Controller
{

    public  function index()
    {
        $orders = Beer::get();
        return '';
    }
}