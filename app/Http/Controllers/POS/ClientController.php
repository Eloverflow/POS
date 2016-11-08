<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Beer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\POS\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
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

        return view('POS.Client.index',compact('title','tableRows', 'tableColumns', 'tableChildren', 'tableChildRows', 'tableChildColumns'));
    }

    public  function edit($slug)
    {
        $title = 'Client';

        /*Main table row to retrieve from DB*/
        $tableRow = Client::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('credit', 'rfid_card_code');


        /*Previous and Next */
        $previousTableRow = Client::find(($tableRow->id)-1);
        $nextTableRow = Client::find(($tableRow->id)+1);

        return view('POS.Client.edit',compact('title','tableRow', 'tableColumns', 'tableChoiceLists', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));
    }

    public  function postEdit($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = Client::whereSlug($slug)->first();


        if( Input::file('image') != null ){
            $image = Input::file('image');
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            /*
                    File::exists(storage_path('img/item/' . $filename)) or File::makeDirectory(storage_path('img/item/' . $filename));*/

            $path = public_path('img/item/' . $filename);
            Image::make($image->getRealPath())/*->resize(400, 550)*/->save($path);
            /*$product->image = 'img/item/'.$filename;
            $product->save();*/

            Session::flash('success', $slug.' image updated!');

            Input::merge(array('img_id' =>  $filename));

        }

        $tableRow->update(Input::all());
        Session::flash('success', $tableRow->slug.' successfully updated');

        return Redirect::back();
    }


    public function details($slug)
    {
        $clients = Client::whereSlug($slug)->first();


        /*Previous and Next */
        $previousTableRow = Client::find(($clients->id)-1);
        $nextTableRow = Client::find(($clients->id)+1);

        return view('POS.Client.details',compact('clients', 'previousTableRow', 'nextTableRow'));
    }

    public function create()
    {
        /*Page Title*/
        $title = 'Clients';

        $tableColumns = array('credit', 'rfid_card_code');


        return view('POS.Client.create',compact('title', 'tableChoiceLists', 'tableColumns'));
    }

    public function postCreate()
    {
        $inputs = Input::all();

        $rules = array(
            'credit' => 'required',
            'rfid_card_code' => 'required'
        );


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

            $client = Client::create([
                'credit' =>  Input::get('credit'),
                'rfid_card_code' => Input::get('rfid_card_code'),
                'slug' => Input::get('rfid_card_code') . '-' . rand(10, 10000)
            ]);

            Session::flash('success', $client->slug.' successfully created');


            return Redirect::back();
        }
    }
}