<?php

namespace App\Http\Controllers\ERP;

use App\Http\Requests;
use App\Models\ERP\Inventory;
use App\Models\ERP\Item;
use App\Models\ERP\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Input;
use Redirect;
use Session;
use DB;

class InventoriesController extends \App\Http\Controllers\Controller
{

    public function index()
    {
        $title = 'Inventory';

        /*Main table row to retrieve from DB*/
        $tableRows = Inventory::all();
        /*Main table desired column to display*/
        $tableColumns = array('id', 'quantity');


        /*Child table name*/
       /* $tableChildName = "item";*/
        /*Child table rows*/
        /*$tableChildRows =  $tableRows->load($tableChildName);*/
        /*Child table desired column to display*/
        /*$tableChildColumns = array('name');*/

        /*$tableChild1 = array("name" => $tableChildName,"rows" => $tableChildRows, "columns" => $tableChildColumns);*/

        /*--------*/

        /*Child table name*/
        $tableChildName = "item";
        /*Child table rows*/
        $tableChildRows =  $tableRows->load($tableChildName);
        /*Child table desired column to display*/
        $tableChildColumns = array('name');

        $tableChild1 = array("name" => $tableChildName,"rows" => $tableChildRows, "columns" => $tableChildColumns);

        $tableChildren = array($tableChild1);


        return view('shared.list',compact('title','tableRows', 'tableColumns', 'tableChildren', 'tableChildRows', 'tableChildColumns'));
    }

    public function emptyEdit()
    {
        function() { return Redirect::to('/inventory');}
    }
    public function edit($slug)
    {
        $title = "Inventory";

        $tableRow = Inventory::whereSlug($slug)->first();

        $tableColumns = array('quantity');


        $tableChoiceListTable = Item::all();
        /*select all where type = beer*/

        $tableChoiceListTitle = "Item ID";
        $tableChoiceListDBColumn = "item_id";
        $tableChoiceListTitleColumn = "name";
        $tableChoiceListContentColumn = "description";
        $tableChoiceListCreateURL = @URL::to('/items');

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);

        /*
                $tableChoiceListTable = Order::all();

                $tableChoiceListTitle = "Order Number";
                $tableChoiceListDBColumn = "order_id";
                $tableChoiceListTitleColumn = "command_number";
                $tableChoiceListContentColumn = "";
                $tableChoiceListCreateURL = @URL::to('/orders/create');

                $tableChoiceList2 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn , "postUrl" => $tableChoiceListCreateURL);
        */


        $tableChoiceLists = array($tableChoiceList1/*, $tableChoiceList2*/);

        /*Child table name
        $tableChild = "";
        /*Child table rows
        $tableChildRows = $tableRow->$tableChild;
        /*Child table desired column to display
        $tableChildColumns = array('img_url');

        /*Previous and Next */
        $previousTableRow = Inventory::findOrNew(($tableRow->id)-1);
        $nextTableRow = Inventory::findOrNew(($tableRow->id)+1);

        return view('shared.edit',compact('title','tableRow', 'tableColumns', 'tableChoiceLists', 'previousTableRow', 'nextTableRow'));
    }

    public function details($slug)
    {
        /*Page Title*/
        $title = 'Inventory';

        /*Main table row to retrieve from DB*/
        $tableRow = Inventory::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('item_id', 'quantity');

        /*Child table name
        $tableChild = "";
        /*Child table rows
        $tableChildRows = $tableRow->$tableChild;
        /*Child table desired column to display
        $tableChildColumns = array('img_url');

        /*Previous and Next */
        $previousTableRow = Inventory::findOrNew(($tableRow->id)-1);
        $nextTableRow = Inventory::findOrNew(($tableRow->id)+1);

        return view('shared.details',compact('title','tableRow', 'tableColumns', 'previousTableRow', 'nextTableRow'));
    }

    public function update($slug, Request $request)
    {
        $item = Inventory::whereId($slug)->first();

        $input = $request->all();

        var_dump($input);

        $item->update($input);

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }

    public function create()
    {

        /*Page Title*/
        $title = 'Inventory';

        /*$formSections = array(
            'section1' => array(
                'title' => '',
                'fields' => array(
                    array(
                        'label' => 'Quantity',
                        'input' => 'quantity'
                    ),
                    array(
                        'label' => 'Quantity',
                        'input' => 'quantity'
                    )
                )
            )
        );*/

        $tableColumns = array('quantity');


        $tableChoiceListTable = Item::all();
        /*select all where type = beer*/

        $tableChoiceListTitle = "Item ID";
        $tableChoiceListDBColumn = "item_id";
        $tableChoiceListTitleColumn = "name";
        $tableChoiceListContentColumn = "description";
        $tableChoiceListCreateURL = @URL::to('/items');

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn, "postUrl" => $tableChoiceListCreateURL);

        /*
                $tableChoiceListTable = Order::all();

                $tableChoiceListTitle = "Order Number";
                $tableChoiceListDBColumn = "order_id";
                $tableChoiceListTitleColumn = "command_number";
                $tableChoiceListContentColumn = "";
                $tableChoiceListCreateURL = @URL::to('/orders/create');

                $tableChoiceList2 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn , "postUrl" => $tableChoiceListCreateURL);
        */


        $tableChoiceLists = array($tableChoiceList1/*, $tableChoiceList2*/);



        return view('shared.create',compact('title', 'tableChoiceLists', 'tableColumns'));
    }

    public function postCreate()
    {
        $inputs = \Input::all();

        $rules = array(
            'quantity' => 'required',
            'item_id' => 'required'
        );

        $message = array(
            'required' => 'The :attribute is required !'
        );

        $validation = \Validator::make($inputs, $rules, $message);
        if($validation -> fails())
        {
            return Redirect::action('ERP\InventoriesController@create')->withErrors($validation)
                ->withInput();
        }
        else
        {
            $inventories = Inventory::where('item_id', '=', Input::get('item_id'))->first();;

            var_dump($inventories);
            if($inventories != null){

                Input::merge(array('quantity' =>  $inventories->quantity + Input::get('quantity')));

                /*$inputs::set('quantity') = $inventories->quantity + $inputs->quantity*/

                $inventories->update(Input::all());

                Session::flash('flash_message', $inventories->slug.' quantity successfully updated!');

            }
            else{

                $itemSlug = Item::whereId(Input::get('item_id'))->first()->slug;

                Inventory::create([
                    'quantity' =>  Input::get('quantity'),
                    'item_id' => Input::get('item_id'),
                    'slug' => $itemSlug
                ]);

                Session::flash('flash_message', $itemSlug . ' successfully created!');
            }

            return Redirect::back();
        }
    }
}