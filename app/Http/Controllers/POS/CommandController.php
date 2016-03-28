<?php

namespace App\Http\Controllers\POS;

use App\Models\ERP\Inventory;
use App\Models\POS\Client;
use App\Models\POS\Sale;
use App\Models\POS\SaleLine;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommandController extends Controller
{

    public function keyboard()
    {
        return view('POS.Command.vKeyboard');
    }

    public function mainmenu()
    {
        return view('POS.Command.main');
    }
}
