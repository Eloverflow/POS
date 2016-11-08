<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\ERP\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        return view('erp.itemtype.index',compact('tableRows', 'columns', 'type', 'title'));
    }


    public function liste()
    {


        $title = 'Items';

        /*Main table row to retrieve from DB*/
        $tableRows = ItemType::all();
        /*Main table desired column to display*/

        return $tableRows;
    }


    public function create()
    {


        $tableColumns = array('type', 'field_names', 'size_names');



        return view('erp.itemtype.create',compact('tableColumns' ));
    }

    public function postCreate()
    {
        $inputs = Input::all();

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
                'type' => Input::get('typeName'),
                'field_names' => Input::get('fieldNames'),
                'size_names' => Input::get('sizeNames'),
                'slug' => Input::get('typeName')
            ]);


            return \Response::json([
                'success' => "The Item type " . Input::get('typeName') . " has been successfully created !",
                'object' => $itemType->id
            ], 201);
        }
    }

    public  function edit($slug)
    {
        $title = 'ItemTypes';

        /*Main table row to retrieve from DB*/
        $tableRow = ItemType::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('type', 'field_names', 'size_names');


        /*Previous and Next */
        $previousTableRow = ItemType::find(($tableRow->id)-1);
        $nextTableRow = ItemType::find(($tableRow->id)+1);

        return view('erp.itemtype.edit',compact('title','tableRow', 'tableColumns', 'tableChoiceLists', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));

    }

    public  function postEdit($slug, Request $request)
    {
        $item = ItemType::whereSlug($slug)->first();

        $input = $request->all();

        var_dump($input);

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }

    public function details($slug)
    {
        $itemtypes = ItemType::whereSlug($slug)->first();


        /*Previous and Next */
        $previousTableRow = ItemType::find(($itemtypes->id)-1);
        $nextTableRow = ItemType::find(($itemtypes->id)+1);

        return view('erp.itemtype.details',compact('itemtypes', 'previousTableRow', 'nextTableRow'));
    }
}