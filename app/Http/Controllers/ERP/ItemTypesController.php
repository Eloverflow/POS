<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\ERP\ItemType;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use DB;

class ItemTypesController extends \App\Http\Controllers\Controller
{

    public  function index()
    {
        /*Main table row to retrieve from DB*/
        $tableRows = ItemType::get();
        $type = 'All';
        $title = 'ItemTypes';
        $columns = array('id', 'type', 'field_names');
        return view('shared.list',compact('tableRows', 'columns', 'type', 'title'));
    }


    public function liste()
    {


        $title = 'Items';

        /*Main table row to retrieve from DB*/
        $tableRows = ItemType::all();
        /*Main table desired column to display*/

        return $tableRows;
    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'fieldNames' => 'required',
            'sizeNames' => 'required',
            'typeName' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            $messages = $validation->errors();
            return \Response::json([
                'errors' => $messages
            ], 422);

        }
        else
        {

            $itemType = ItemType::create([
                'type' => \Input::get('typeName'),
                'field_names' => \Input::get('fieldNames'),
                'size_names' => \Input::get('sizeNames'),
                'slug' => \Input::get('typeName')
            ]);


            return \Response::json([
                'success' => "The Item type " . \Input::get('typeName') . " has been successfully created !",
                'object' => $itemType->id
            ], 201);
        }
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
        $title = 'ItemTypes';

        /*Main table row to retrieve from DB*/
        $tableRow = ItemType::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('type', 'field_names', 'size_names');


        /*$tableChoiceListTable = ItemType::all();*/
        /*select all where type = beer*/

        /*$tableChoiceListTitle = "Item Type";
        $tableChoiceListDBColumn = "item_type_id";
        $tableChoiceListTitleColumn = "type";
        $tableChoiceListContentColumn = "";
        $tableChoiceListCreateURL = @URL::to('/itemtypes');

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);

        $tableChoiceLists = array($tableChoiceList1, $tableChoiceList2);*/


        /*Previous and Next */
        $previousTableRow = ItemType::findOrNew(($tableRow->id)-1);
        $nextTableRow = ItemType::findOrNew(($tableRow->id)+1);

        return view('shared.edit',compact('title','tableRow', 'tableColumns', 'tableChoiceLists', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));

        $item = ItemType::whereSlug($slug)->first();
        $title = 'itemtypes';
        $next_item = ItemType::findOrNew(($item->id)+1);
        $previous_item = ItemType::findOrNew(($item->id)-1);

        $customsFields = explode(',', $item->customs_fields_names);

        $columns = array('type', 'fields_names');

        return view('erp.items.types.edit',compact('item', 'customsFields', 'slug', 'title','columns','next_item','previous_item'));
    }

    public  function update($slug, Request $request)
    {
        $item = ItemType::whereSlug($slug)->first();

        $input = $request->all();

        var_dump($input);

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }
}