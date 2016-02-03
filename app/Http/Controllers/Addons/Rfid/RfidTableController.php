<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfid;
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
        $tableColumns = array('name');

        /*Child table name*/
        $tableChild = "tableRfidbeer";
        /*Child table rows*/
        $tableChildRows = $tableRow->$tableChild;
        /*Child table desired column to display*/
        $tableChildColumns = array('img_url');

        /*Previous and Next */
        $previousTableRow = TableRfid::findOrNew(($tableRow->id)-1);
        $nextTableRow = TableRfid::findOrNew(($tableRow->id)+1);


        return view('addins.rfid.table.edit',compact('title','tableRow', 'tableColumns', 'tableChildRows', 'tableChildColumns', 'previousTableRow', 'nextTableRow'));
    }

    public  function update($slug, Request $request)
    {
        /*Main table row to retrieve from DB*/
        $tableRow = TableRfid::whereSlug($slug)->first();

        /*Child table name*/
        $tableChild = "tableRfidbeer";
        /*Child table rows*/
        $tableChildRows = $tableRow->$tableChild;

        $input = $request->all();

        $tableRow->update($input);

        if(is_array($tableChildRows)){
            foreach($tableChildRows as $tableChildRow){
                $tableChildRow->update($input);
            }
        }
        else
        {
            $tableChildRows->update($input);
        }


        Session::flash('flash_message', $slug.' successfully updated!');

        return Redirect::back();
    }

}

