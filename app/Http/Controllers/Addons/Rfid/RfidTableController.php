<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

class RfidTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = TableRfid::get();

        $title = "test";

        $columns = array('id', 'flash_card_hw_code', 'name');

        return view('addins.rfid.request.list', compact('title', 'items', 'columns'));
    }

    protected function create(Request $request)
    {

        $input = $request->all();

        var_dump($input);

        return TableRfid::create([
            'flash_card_hw_code' => $input['flash_card_hw_code'],
            'name' => $input['name'],
        ]);
    }

}

