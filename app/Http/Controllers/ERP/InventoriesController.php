<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Inventory;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use DB;

class InventoriesController extends \App\Http\Controllers\Controller
{

    public  function index()
    {
        $items = Inventory::get();
        $title = 'inventory';
        $columns = array('id', 'item_id', 'order_id', 'quantity');
        return view('erp.inventory.list',compact('items', 'columns', 'title'));
    }

    public  function edit($slug)
    {
        $item = Inventory::whereId($slug)->first();
        $title = 'inventory';
        $next_item = Inventory::findOrNew(($item->id)+1);
        $previous_item = Inventory::findOrNew(($item->id)-1);

        $columns = array('item_id', 'order_id', 'quantity');

        return view('erp.inventory.edit',compact('item', 'title','columns','next_item','previous_item'));
    }

    public  function update($slug, Request $request)
    {
        $item = Inventory::whereId($slug)->first();

        $input = $request->all();

        var_dump($input);

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}