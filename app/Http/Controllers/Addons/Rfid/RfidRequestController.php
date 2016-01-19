<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfidRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

class RfidRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "test";

        $items = TableRfidRequest::get();

        $columns = array('id', 'flash_card_hw_code', 'rfid_card_code');

        return view('addins.rfid.request.list', compact('title', 'items', 'columns'));
    }

    protected function create(Request $request)
    {

        $input = $request->all();

        var_dump($input);

        return TableRfidRequest::create([
            'flash_card_hw_code' => $input['flash_card_hw_code'],
            'rfid_card_code' => $input['rfid_card_code'],
        ]);
    }

    protected function checkTableRequest(Request $request)
    {

        $input = $request->all();

        var_dump($input);

        return TableRfidRequest::whereId($input['flash_card_hw_code'])->last();
    }
}

