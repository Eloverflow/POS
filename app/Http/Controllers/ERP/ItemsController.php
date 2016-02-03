<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Item;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class ItemsController extends Controller
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
        $title = 'Items';

        /*Main table row to retrieve from DB*/
        $tableRow = Item::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('name', 'description' );

        /*Child table name*/
        $tableChild = "itemtype";
        /*Child table rows*/
        $tableChildRows = $tableRow->$tableChild;
        /*Child table desired column to display*/
        $tableChildColumns = array('type');

        /*Previous and Next */
        $previousTableRow = Item::findOrNew(($tableRow->id)-1);
        $nextTableRow = Item::findOrNew(($tableRow->id)+1);

        return view('erp.items.edit',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));
    }



    public  function update($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = Item::whereSlug($slug)->first();

        /*Child table name*/
        $tableChild = "itemtype";
        /*Child table rows*/
        $tableChildRows = $tableRow->$tableChild;

        $input = $request->all();

        $tableRow->update($input);

        if(is_array($tableChildRows)){
            foreach($tableChildRows as $tableChildRow){
                $tableChildRow->update($input);
            }
        }
        else
        {
            $tableChildRows->update($input);
        }


        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}