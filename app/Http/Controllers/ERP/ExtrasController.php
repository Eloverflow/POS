<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Extra;
use App\Models\ERP\ExtraItem;
use App\Models\ERP\ExtraItemType;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use URL;
use Validator;

class ExtrasController extends Controller
{

    public  function index()
    {
/*
        $extras = Extra::with('extra_item')->get();
        var_dump($extras->extra_item->id);*/

        $extras = Extra::all();

        foreach ($extras as $extra)
        {
            $extraItems = ExtraItem::where('extra_id', $extra->id)->get();
            $extraItemTypes = ExtraItemType::where('extra_id', $extra->id)->get();

            $extra['items'] = $extraItems->load('item');
            $extra['itemtypes'] = $extraItemTypes->load('itemtype');
        }


        return view('erp.extra.index',compact('title', 'extras'));
    }

    public  function create()
    {




        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value');

        $items = Item::all();
        $itemtypes = ItemType::all();




        return view('erp.extra.create',compact('title', 'tableColumns', 'items', 'itemtypes' ));

    }

    public  function postCreate()
    {

        $inputs = \Input::all();

        $rules = array(
            'name' => 'required',
            'description' => 'required'
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

            $extra = Extra::create([
                'name' =>  Input::get('name'),
                'description' => Input::get('description'),
                'slug' => Input::get('name') . rand(10, 10000),
                'effect' => Input::get('effect'),
                'value' => Input::get('value')
            ]);


            foreach ($inputs['items'] as $itemId){
                ExtraItem::create(['item_id' => $itemId,'extra_id' =>$extra->id]);
            }

            foreach ($inputs['itemtypes']  as $itemTypeId){
                ExtraItemType::create(['item_type_id' => $itemTypeId,'extra_id' =>$extra->id]);
            }


        }

        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value');

        $items = Item::all();
        $itemtypes = ItemType::all();


        return view('erp.extra.create',compact('title', 'tableColumns', 'items', 'itemtypes' ));

    }

}