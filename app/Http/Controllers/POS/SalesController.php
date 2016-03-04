<?php

namespace App\Http\Controllers\POS;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "SalesController";
    }

    public function menu()
    {
        return view('POS.Sale.menu');
    }
}
