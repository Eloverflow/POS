<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfid;
use App\Models\ERP\Item;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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
        $tableRows = TableRfid::get();

        $tableRows->load('beer1');
        $tableRows->load('beer2');

        $columns = array('name','flash_card_hw_code', 'phone_hw_code');

        return view('addins.rfid.table.index', compact('title', 'tableRows', 'columns'));
    }

/*    protected function create(Request $request)
    {

        $input = $request->all();

        var_dump($input);

        return TableRfid::create([
            'flash_card_hw_code' => $input['flash_card_hw_code'],
            'name' => $input['name'],
        ]);
    }*/


    public  function create()
    {
        /*Main table desired column to display*/
        $tableColumns = array('name', 'phone_hw_code', 'flash_card_hw_code');

        $tableChoiceListTable = Item::where('item_type_id', '1')->get();

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

        return view('addins.rfid.table.create',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow', 'tableChoiceLists'));
    }

    public function postCreate()
    {

        $tableSlug = Input::get('flash_card_hw_code');

        $table = TableRfid::create([
            'flash_card_hw_code' =>  Input::get('flash_card_hw_code'),
            'phone_hw_code' => Input::get('phone_hw_code'),
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'beer1_item_id' => Input::get('beer1_item_id'),
            'beer2_item_id' => Input::get('beer2_item_id'),
            'slug' => $tableSlug
        ]);

        Session::flash('success', $table->slug.' '. trans('flashmsg.successCreate'));

        return Redirect::action('Addons\Rfid\RfidTableController@index');
    }

    public  function edit($slug)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();

        /*Main table desired column to display*/
        $tableColumns = array('name', 'phone_hw_code', 'flash_card_hw_code');

        $tableChoiceListTable = Item::where('item_type_id', '1')->get();

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

        /*Previous and Next */
        $previousTableRow = TableRfid::find(($tableRow->id)-1);
        $nextTableRow = TableRfid::find(($tableRow->id)+1);


        return view('addins.rfid.table.edit',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow', 'tableChoiceLists'));
    }

    public function postEdit($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();

        $input = $request->all();

        $tableRow->update($input);

        Session::flash('success', $tableRow->slug.' '. trans('flashmsg.successUpdate'));

        return Redirect::action('Addons\Rfid\RfidTableController@index');
    }


    public  function details($slug)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();
        /*Main table desired column to display*/
        $tableColumns = array('name', 'phone_hw_code', 'flash_card_hw_code');

        $tableChoiceListTable = Item::where('item_type_id', '1')->get();

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

        /*Previous and Next */
        $previousTableRow = TableRfid::find(($tableRow->id)-1);
        $nextTableRow = TableRfid::find(($tableRow->id)+1);

        return view('addins.rfid.table.details',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow', 'tableChoiceLists'));
    }

    public function getBeers(Request $request)
    {
        $input = $request->all();
        $table = TableRfid::where('phone_hw_code', $input['phone_hw_code'])->first();

        if($table == null){
            $table = TableRfid::create([
                'phone_hw_code' => $input['phone_hw_code'],
                'name' => $input['phone_hw_code'],
                'slug' => $input['phone_hw_code']
            ]);

            //Avec une default beer peut-être ?
        }

        $beers = array('beer1' => $table->beer1, 'beer2' => $table->beer2, 'table' => $table);
        Return $beers;
    }



}

