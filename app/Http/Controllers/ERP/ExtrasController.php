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
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use URL;
use Validator;

class ExtrasController extends Controller
{

    public  function index()
    {

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

    public  function liste()
    {

        $extras = Extra::all();

        foreach ($extras as $extra)
        {
            $extraItems = ExtraItem::where('extra_id', $extra->id)->get();
            $extraItemTypes = ExtraItemType::where('extra_id', $extra->id)->get();

            $extra['items'] = $extraItems->load('item');
            $extra['itemtypes'] = $extraItemTypes->load('itemtype');
        }


        return $extras;
    }

    public  function create()
    {




        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value', 'avail_for_command');

        $items = Item::all();
        $itemtypes = ItemType::all();




        return view('erp.extra.create',compact('title', 'tableColumns', 'items', 'itemtypes' ));

    }

    public function edit($slug)
    {


        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value', 'avail_for_command');

        $extra = Extra::whereSlug($slug)->first();

        $extraItems = ExtraItem::where('extra_id', $extra->id)->get();
        $extraItemTypes = ExtraItemType::where('extra_id', $extra->id)->get();

        $extra['items'] = $extraItems->load('item');
        $extra['itemtypes'] = $extraItemTypes->load('itemtype');


        $items = Item::all();
        $itemtypes = ItemType::all();

        foreach ($extra['items'] as $item){
        Item::where('id', $item->id)->get();
        }



        return view('erp.extra.edit',compact('title', 'extra', 'tableColumns', 'items', 'itemtypes' ));

    }

    public  function postCreate()
    {

        $inputs = Input::all();

        $rules = array(
            'name' => 'required'
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
                'value' => Input::get('value'),
                'avail_for_command' => Input::get('avail_for_command')
            ]);


            if(!empty($inputs['items']))
            foreach ($inputs['items'] as $itemId){
                ExtraItem::create(['item_id' => $itemId,'extra_id' =>$extra->id]);
            }

            if(!empty($inputs['itemtypes']))
            foreach ($inputs['itemtypes']  as $itemTypeId){
                ExtraItemType::create(['item_type_id' => $itemTypeId,'extra_id' =>$extra->id]);
            }


        }

        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value', 'avail_for_command');

        $items = Item::all();
        $itemtypes = ItemType::all();


        return Redirect::to('/extras')->with('success', '');

    }

    public  function postEdit($slug)
    {

        $inputs = Input::all();

        $rules = array(
            'name' => 'required'
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

            $extra = Extra::whereSlug($slug)->first();

            $extraItems = ExtraItem::where('extra_id', $extra->id)->get();
            $extraItemTypes = ExtraItemType::where('extra_id', $extra->id)->get();

            $extraItem = $extraItems->load('item');
            $extraItemtype = $extraItemTypes->load('itemtype');


            foreach ($extraItem as $item){
                $item->delete();
            }

            foreach ($extraItemtype as $itemtype){
                $itemtype->delete();
            }

            if(!empty($inputs['items']))
            foreach ($inputs['items'] as $itemId){
                ExtraItem::create(['item_id' => $itemId,'extra_id' =>$extra->id]);
            }

            if(!empty($inputs['itemtypes']))
            foreach ($inputs['itemtypes']  as $itemTypeId){
                ExtraItemType::create(['item_type_id' => $itemTypeId,'extra_id' =>$extra->id]);
            }


            $extra->update([
                'name' =>  Input::get('name'),
                'description' => Input::get('description'),
                'effect' => Input::get('effect'),
                'value' => Input::get('value'),
                'avail_for_command' => Input::get('avail_for_command')
            ]);
            $extra->save();


        }

        /*Page Title*/
        $title = 'Extra';

        $tableColumns = array('name', 'description', 'effect', 'value', 'avail_for_command');

        $items = Item::all();
        $itemtypes = ItemType::all();

        $extra = Extra::whereSlug($slug)->first();

        $extraItems = ExtraItem::where('extra_id', $extra->id)->get();
        $extraItemTypes = ExtraItemType::where('extra_id', $extra->id)->get();

        $extraItem = $extraItems->load('item');
        $extraItemtype = $extraItemTypes->load('itemtype');

        $extra['items'] = $extraItem;
        $extra['itemtypes'] = $extraItemtype;


        return view('erp.extra.edit',compact('title','extra', 'tableColumns', 'items', 'itemtypes' ));

    }

}