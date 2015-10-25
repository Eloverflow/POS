<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Item;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class ItemsController extends \App\Http\Controllers\Controller
{

    public  function index()
    {
        /*$items = Item::get();*/
        $items = Item::with('itemtype')->get();

        $title = "Items";
        $columns = array('id', 'name');
        $columnsWith = array('type');
        $withName = 'itemtype';
        return view('erp.items.list',compact('items', 'columns', 'columnsWith', 'withName', 'title'));
    }

    public  function edit($slug)
    {

        $title = "Items";
        $columns = array('id', 'name', 'description' );
        $item = Item::whereSlug($slug)->first();
        $item::with('itemtype')->get();

        $columnsWith = array('type');
        $withName = 'itemtype';

        columnsField

        $next_item = Item::findOrNew(($item->id)+1);
        $previous_item = Item::findOrNew(($item->id)-1);
        return view('erp.items.edit',compact('item', 'columns', 'columnsWith', 'withName', 'next_item', 'previous_item', 'title'));
    }



    public  function update($slug, Request $request)
    {
        $beer = Item::whereSlug($slug)->first();

        $input = $request->all();

        $beer->update($input);


        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}