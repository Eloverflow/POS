<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\ERP\Inventory;
use App\Models\ERP\Item;
use App\Models\ERP\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use DB;

class InventoriesController extends \App\Http\Controllers\Controller
{

    public function index()
    {
        $inventories = Inventory::all();

   /*     foreach ($inventories as $inventory)
        {
            $inventoryItems = ExtraItem::where('inventory_id', $inventory->id)->get();
            $inventoryItemTypes = ExtraItemType::where('inventory_id', $inventory->id)->get();

            $inventory['items'] = $inventoryItems->load('item');
            $inventory['itemtypes'] = $inventoryItemTypes->load('itemtype');
        }*/

        $inventories->load('item');

        return view('erp.inventory.index',compact('title', 'inventories'));
    }

    public function edit($slug)
    {

        $inventory = Inventory::whereSlug($slug)->first();


        /*Previous and Next */
        $previousTableRow = Inventory::find(($inventory->id)-1);
        $nextTableRow = Inventory::find(($inventory->id)+1);

        return view('erp.inventory.edit',compact('inventory', 'previousTableRow', 'nextTableRow'));
    }

    public function details($slug)
    {
        $inventory = Inventory::whereSlug($slug)->first();


        /*Previous and Next */
        $previousTableRow = Inventory::findOrNew(($inventory->id)-1);
        $nextTableRow = Inventory::findOrNew(($inventory->id)+1);

        return view('erp.inventory.details',compact('inventory', 'previousTableRow', 'nextTableRow'));
    }

    public function postEdit($slug, Request $request)
    {
        $item = Inventory::whereSlug($slug)->first();

        $input = $request->all();

        $item->update($input);

        Session::flash('success', $slug.' '. trans('flashmsg.successUpdate'));

        return Redirect::action('ERP\InventoriesController@index');
    }

    public function create()
{

    $items = Item::all();
    $items->load('itemtype');

    $tableChoiceListTable = $items;
    /*select all where type = beer*/

    $tableChoiceListTitle = "Item";
    $tableChoiceListDBColumn = "item_id";
    $tableChoiceListTitleColumn = "name";
    $tableChoiceListContentColumn = "";
    $tableChoiceListCreateURL = @URL::to('/items');

    $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);


    $tableChoiceLists = array($tableChoiceList1);



    return view('erp.inventory.create',compact('title', 'tableColumns', 'tableChoiceLists' ));
}

    public function postCreate()
    {
        $inputs = Input::all();

        $rules = array(
            'quantity' => 'required',
            'item_size' => 'required',
            'item_id' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation->fails())
        {
            return Redirect::action('ERP\InventoriesController@create')->withErrors($validation)
                ->withInput();
        }
        else
        {
            $inventories = Inventory::where([['item_id', '=', Input::get('item_id')],['item_size', '=', Input::get('item_size')]])->first();;

            if($inventories != null){

                Input::merge(array('quantity' =>  $inventories->quantity + Input::get('quantity')));

                /*$inputs::set('quantity') = $inventories->quantity + $inputs->quantity*/

                $inventories->update(Input::all());

                Session::flash('success', $inventories->slug.' '. trans('flashmsg.successUpdate'));

            }
            else{

                $itemSlug = strtolower(Item::whereId(Input::get('item_id'))->first()->slug . '-' . Input::get('item_size'));

                Inventory::create([
                    'quantity' =>  Input::get('quantity'),
                    'item_id' => Input::get('item_id'),
                    'item_size' => Input::get('item_size'),
                    'slug' => $itemSlug
                ]);

                Session::flash('success', $itemSlug.' '. trans('flashmsg.successCreate'));
            }

            return Redirect::back();
        }
    }
}