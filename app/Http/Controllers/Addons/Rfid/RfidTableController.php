<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfid;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;
use Session;

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

        $title = "Table";

        $columns = array('flash_card_hw_code', 'name');

        return view('addins.rfid.table.list', compact('title', 'items', 'columns'));
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


    public  function edit($slug)
    {
        $itemB4Join = TableRfid::whereSlug($slug)->first();
        $item = $itemB4Join->with('tableRfidBeer')->get();
        $title = 'table';
        $next_item = TableRfid::findOrNew(($itemB4Join->id)+1);
        $previous_item = TableRfid::findOrNew(($itemB4Join->id)-1);

        $columns = array('name');
        $columnsWith = array('img_url');
        $withName = "tableRfidBeer";


        return view('addins.rfid.table.edit',compact('item', 'slug', 'title','columns', 'columnsWith', 'withName', 'next_item','previous_item'));
    }

    public  function update($slug, Request $request)
    {
        $item = TableRfid::whereSlug($slug)->first();

        $input = $request->all();

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }

}

