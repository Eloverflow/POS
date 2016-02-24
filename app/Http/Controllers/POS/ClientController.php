<?php

namespace App\Http\Controllers\ERP;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Input;
use Intervention\Image\Facades\Image;
use Redirect;
use Session;
use URL;
use Validator;

class ClientController extends Controller
{

    public  function index()
    {
        /*$items = Item::get();*/
        /*$items = Item::with('itemtype')->get();

        $title = "Items";
        $columns = array('id', 'name');
        $columnsWith = array('type');
        $withName = 'itemtype';
        return view('erp.items.list',compact('items', 'columns', 'columnsWith', 'withName', 'title'));*/

        $title = 'Clients';

        /*Main table row to retrieve from DB*/
        $tableRows = Client::all();
        /*Main table desired column to display*/
        $tableColumns = array('id', 'credit', 'rfid_card_code');

        return view('shared.list',compact('title','tableRows', 'tableColumns', 'tableChildren', 'tableChildRows', 'tableChildColumns'));
    }

    public  function edit($slug)
    {
        $title = 'Items';

        /*Main table row to retrieve from DB*/
        $tableRow = Item::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('name', 'description' ,'img_id');


        $tableChoiceListTable = ItemType::all();
        /*select all where type = beer*/

        $tableChoiceListTitle = "Item Type";
        $tableChoiceListDBColumn = "item_type_id";
        $tableChoiceListTitleColumn = "type";
        $tableChoiceListContentColumn = "";
        $tableChoiceListCreateURL = @URL::to('/itemtypes');

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);

        $tableChoiceLists = array($tableChoiceList1/*, $tableChoiceList2*/);


        /*Previous and Next */
        $previousTableRow = Item::findOrNew(($tableRow->id)-1);
        $nextTableRow = Item::findOrNew(($tableRow->id)+1);

        return view('shared.edit',compact('title','tableRow', 'tableColumns', 'tableChoiceLists', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));
    }



    public  function update($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = Item::whereSlug($slug)->first();

        /*Child table name*/
        $tableChild = "itemtype";
        /*Child table rows*/
        $tableChildRows = $tableRow->$tableChild;



        if( Input::file('image') != null ){
            $image = Input::file('image');
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            /*
                    File::exists(storage_path('img/item/' . $filename)) or File::makeDirectory(storage_path('img/item/' . $filename));*/

            $path = public_path('img/item/' . $filename);
            Image::make($image->getRealPath())/*->resize(400, 550)*/->save($path);
            /*$product->image = 'img/item/'.$filename;
            $product->save();*/


            Session::flash('flash_message', $slug.' image updated!');


            Input::merge(array('img_id' =>  $filename));

        }



        $tableRow->update(Input::all());


        if(is_array($tableChildRows)){
            foreach($tableChildRows as $tableChildRow){
                $tableChildRow->update(Input::all());
            }
        }
        else
        {
            $tableChildRows->update(Input::all());
        }

        // resizing an uploaded file/*

        /*Image::make(Input::file('image'))->resize(300, 200)->save('foo.jpg');*/

/*
        $file = Input::file('image');
        $filename = "test";
        Image::make($file->getRealPath())->resize('200','200')->save($filename);*/




        return Redirect::back();
    }

    public function create()
    {
        /*Page Title*/
        $title = 'Items';

        $tableColumns = array('name', 'description');


        $tableChoiceListTable = ItemType::all();
        /*select all where type = beer*/

        $tableChoiceListTitle = "ItemType";
        $tableChoiceListDBColumn = "item_type_id";
        $tableChoiceListTitleColumn = "type";
        $tableChoiceListContentColumn = "";
        $tableChoiceListCreateURL = @URL::to('/itemtypes');

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);


        $tableChoiceLists = array($tableChoiceList1);



        return view('shared.create',compact('title', 'tableChoiceLists', 'tableColumns'));
    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'name' => 'required',
            'description' => 'required'
        );

        if(!Input::get('item_type_id'))
        Input::merge(array('item_type_id' =>  1));

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return Redirect::action('ERP\ItemsController@create')->withErrors($validation)
                ->withInput();
        }
        else
        {

            return Item::create([
                'name' =>  Input::get('name'),
                'description' => Input::get('description'),
                'slug' => Input::get('name') . rand(10, 10000),
                'item_type_id' => Input::get('item_type_id'),
                'item_field_list_id' => Input::get('item_type_id')
            ]);
        }
    }
}