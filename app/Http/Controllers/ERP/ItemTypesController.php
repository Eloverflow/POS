<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\ERP\ItemType;
use App\Models\ERP\ItemTypes\ItemTypeBeer;
use App\Models\ERP\ItemTypes\ItemTypeDrink;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use DB;

class ItemTypesController extends \App\Http\Controllers\Controller
{

    public  function index()
    {
        $items = ItemType::get();
        $type = 'All';
        $title = 'ItemTypes';
        $columns = array('id', 'type');
        return view('erp.items.types.list',compact('items', 'columns', 'type', 'title'));
    }

    /*public  function type($type)
    {
        $title = ucfirst($type);
        $table = 'item_type_' . $type. 's';
        $items = DB::select('SELECT * FROM item_types INNER JOIN item_type_beers ON item_types.id=item_type_beers.item_type_id' .$table);
        $columns = array('id', 'style');
        return view('erp.items.types.list',compact('items', 'columns', 'type', 'title'));
    }*/

    public  function edit($slug)
    {
        $item = ItemType::whereSlug($slug)->first();
        $title = 'itemtypes';
        $next_item = ItemType::findOrNew(($item->id)+1);
        $previous_item = ItemType::findOrNew(($item->id)-1);

        $customsFields = explode(',', $item->customs_fields_names);

        $columns = array('id', 'type');

        return view('erp.items.types.edit',compact('item', 'customsFields', 'slug', 'title','columns','next_item','previous_item'));
    }

    public  function update($type, $slug, Request $request)
    {
        $item = $type::whereSlug($slug)->first();

        $input = $request->all();

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}