<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfid;
use App\Models\ERP\Item;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;
use Session;

class RfidTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = TableRfid::get();

        $title = "Table";

        $columns = array('flash_card_hw_code', 'name');

        return view('addins.rfid.table.list', compact('title', 'items', 'columns'));
    }

    protected function create(Request $request)
    {

        $input = $request->all();

        var_dump($input);

        return TableRfid::create([
            'flash_card_hw_code' => $input['flash_card_hw_code'],
            'name' => $input['name'],
        ]);
    }


    public  function edit($slug)
    {
        /*Page Title*/
        $title = 'table';

        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('name', 'phone_hw_code', 'flash_card_hw_code');


        $tableChoiceListTable = Item::where('item_type_id', '1')->get();
/*
        var_dump($tableChoiceListTable);*/
        /*select all where type = beer*/

        $tableChoiceListTitle = "Beer 1";
        $tableChoiceListDBColumn = "beer1_item_id";
        $tableChoiceListTitleColumn = "name";
        $tableChoiceListContentColumn = "description";

        $tableChoiceList1 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn);


        $tableChoiceListTitle = "Beer 2";
        $tableChoiceListDBColumn = "beer2_item_id";
        $tableChoiceListTitleColumn = "name";
        $tableChoiceListContentColumn = "description";

        $tableChoiceList2 = array("table" => $tableChoiceListTable,"title" => $tableChoiceListTitle, "dbColumn" => $tableChoiceListDBColumn, "titleColumn" => $tableChoiceListTitleColumn, "contentColumn" => $tableChoiceListContentColumn);



        $tableChoiceLists = array($tableChoiceList1, $tableChoiceList2);

        /*Child table name
        $tableChild = "tableRfidbeer";
        /*Child table rows
        $tableChildRows = $tableRow->$tableChild;
        /*Child table desired column to display
        $tableChildColumns = array('img_url');

        /*Previous and Next */
        $previousTableRow = TableRfid::findOrNew(($tableRow->id)-1);
        $nextTableRow = TableRfid::findOrNew(($tableRow->id)+1);


        return view('addins.rfid.table.edit',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow', 'tableChoiceLists'));
    }

    public function update($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();


        $input = $request->all();

        $tableRow->update($input);

        /*Child table name
        $tableChild = "tableRfidbeer";
        /*Child table rows
        $tableChildRows = $tableRow->$tableChild;



        if(is_array($tableChildRows)){
            foreach($tableChildRows as $tableChildRow){
                $tableChildRow->update($input);
            }
        }
        else
        {
            $tableChildRows->update($input);
        }

        */

        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }

    public function getBeers(Request $request)
    {
        $input = $request->all();
/*
        $typeBeer = Item::where('type' , '=', 'beer');*/
/*
        $table = TableRfid::where('flash_card_hw_code', '=', $input['flash_card_hw_code'])->where('item_type_id' , '=', $typeBeer->id )->first();*/
        $table = TableRfid::where('phone_hw_code', $input['phone_hw_code'])->first();

        if($table == null){
            $table = TableRfid::create([
                'phone_hw_code' => $input['phone_hw_code'],
                'name' => $input['phone_hw_code'],
                'slug' => $input['phone_hw_code']
            ]);
        }

        $beers = array('beer1' => $table->beer1, 'beer2' => $table->beer2);
        Return $beers;

        /*return Response::make($content)->withCookie($cookie);*/
    }

}

