<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Filter;
use App\Models\POS\FilterItem;
use App\Models\POS\FilterItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use URL;
use Validator;

class FiltersController extends Controller
{

    public  function index()
    {

        $filters = Filter::all();

        foreach ($filters as $filter)
        {
            $filterItems = FilterItem::where('filter_id', $filter->id)->get();
            $filterItemTypes = FilterItemType::where('filter_id', $filter->id)->get();

            $filter['items'] = $filterItems->load('item');
            $filter['itemtypes'] = $filterItemTypes->load('itemtype');
        }


        return view('POS.filter.index',compact('title', 'filters'));
    }

    public  function liste()
    {

        $filters = Filter::all();

        foreach ($filters as $filter)
        {
            $filterItems = FilterItem::where('filter_id', $filter->id)->get();
            $filterItemTypes = FilterItemType::where('filter_id', $filter->id)->get();

            $filter['items'] = $filterItems->load('item');
            $filter['itemtypes'] = $filterItemTypes->load('itemtype');
        }


        return $filters;
    }

    public  function create()
    {




        /*Page Title*/
        $title = 'Filter';

        $tableColumns = array('name', 'description', 'importance');

        $items = Item::all();
        $itemtypes = ItemType::all();




        return view('POS.filter.create',compact('title', 'tableColumns', 'items', 'itemtypes' ));

    }

    public function edit($slug)
    {


        /*Page Title*/
        $title = 'Filter';

        $tableColumns = array('name', 'description', 'importance');

        $filter = Filter::whereSlug($slug)->first();

        $filterItems = FilterItem::where('filter_id', $filter->id)->get();
        $filterItemTypes = FilterItemType::where('filter_id', $filter->id)->get();

        $filter['items'] = $filterItems->load('item');
        $filter['itemtypes'] = $filterItemTypes->load('itemtype');


        $items = Item::all();
        $itemtypes = ItemType::all();

        foreach ($filter['items'] as $item){
        Item::where('id', $item->id)->get();
        }



        return view('POS.filter.edit',compact('title', 'filter', 'tableColumns', 'items', 'itemtypes' ));

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

            $filter = Filter::create([
                'name' =>  Input::get('name'),
                'description' => Input::get('description'),
                'slug' => Input::get('name') . rand(10, 10000),
                'importance' => Input::get('importance'),
                'status' => 1,
                'type' => 1
            ]);


            if(!empty($inputs['items']))
            foreach ($inputs['items'] as $itemId){
                FilterItem::create(['item_id' => $itemId,'filter_id' =>$filter->id]);
            }

            if(!empty($inputs['itemtypes']))
            foreach ($inputs['itemtypes']  as $itemTypeId){
                FilterItemType::create(['item_type_id' => $itemTypeId,'filter_id' =>$filter->id]);
            }


        }

        /*Page Title*/
        $title = 'Filter';

        $tableColumns = array('name', 'description', 'importance');

        $items = Item::all();
        $itemtypes = ItemType::all();


        return Redirect::to('/filters')->with('success', '');

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

            $filter = Filter::whereSlug($slug)->first();

            $filterItems = FilterItem::where('filter_id', $filter->id)->get();
            $filterItemTypes = FilterItemType::where('filter_id', $filter->id)->get();

            $filterItem = $filterItems->load('item');
            $filterItemtype = $filterItemTypes->load('itemtype');


            foreach ($filterItem as $item){
                $item->delete();
            }

            foreach ($filterItemtype as $itemtype){
                $itemtype->delete();
            }

            if(!empty($inputs['items']))
            foreach ($inputs['items'] as $itemId){
                FilterItem::create(['item_id' => $itemId,'filter_id' =>$filter->id]);
            }

            if(!empty($inputs['itemtypes']))
            foreach ($inputs['itemtypes']  as $itemTypeId){
                FilterItemType::create(['item_type_id' => $itemTypeId,'filter_id' =>$filter->id]);
            }


            $filter->update([
                'name' =>  Input::get('name'),
                'description' => Input::get('description'),
                'importance' => Input::get('importance')
            ]);
            $filter->save();


        }

        /*Page Title*/
        $title = 'Filter';

        $tableColumns = array('name', 'description', 'importance');

        $items = Item::all();
        $itemtypes = ItemType::all();

        $filter = Filter::whereSlug($slug)->first();

        $filterItems = FilterItem::where('filter_id', $filter->id)->get();
        $filterItemTypes = FilterItemType::where('filter_id', $filter->id)->get();

        $filterItem = $filterItems->load('item');
        $filterItemtype = $filterItemTypes->load('itemtype');

        $filter['items'] = $filterItem;
        $filter['itemtypes'] = $filterItemtype;


        return view('POS.filter.edit',compact('title','filter', 'tableColumns', 'items', 'itemtypes' ));

    }

}