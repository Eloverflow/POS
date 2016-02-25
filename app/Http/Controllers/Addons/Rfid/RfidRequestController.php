<?php

namespace App\Http\Controllers\Addons\Rfid;

use App\Models\Addons\Rfid\TableRfidRequest;
use App\Models\ERP\Inventory;
use App\Models\ERP\Item;
use App\Models\POS\Client;
use App\Models\POS\Sale;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

class RfidRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "test";

        $items = TableRfidRequest::get();

        $columns = array('id', 'flash_card_hw_code', 'rfid_card_code');

        return view('addins.rfid.request.list', compact('title', 'items', 'columns'));
    }

    protected function create(Request $request)
    {

        $input = $request->all();

        return TableRfidRequest::create([
            'flash_card_hw_code' => $input['flash_card_hw_code'],
            'rfid_card_code' => $input['rfid_card_code'],
        ]);
    }

    protected function checkTableRequest(Request $request)
    {
        $result = array('msg' => '', 'request' => '');

        $result['msg'] = "No scan request found in the last 10 sec for this rfid table";
        $input = $request->all();

        /*var_dump($input);*/

        $lastRequest = TableRfidRequest::where('flash_card_hw_code', $input['flash_card_hw_code'])
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();

        $currentDate = new DateTime(date('Y-m-d H:i:s'));

        $requestDate = new DateTime($lastRequest[0]['created_at']);

        $interval =  $currentDate->diff($requestDate);
        /* We also need to verify the time since the last request at this table to avoid double order*/

       /* echo $interval->format('%Y%M%D%H%I%S');*/

        if($interval->format('%Y%M%D%H%I%S') < 10){

            /*Here we do the request to unluck the beer*/


            $inventory = Inventory::where('item_id', $input['item_id'])->first();



            $client = Client::where('rfid_card_code', $lastRequest[0]->rfid_card_code )->first();


            if($client->credit > 0)
            {

                $result['request'] = $lastRequest;

                if($inventory != ""){

                    //Reducing inventory
                    Input::replace(array('quantity' =>  $inventory->quantity - 1));
                    $inventory->update(Input::all());
                }


                $item = Item::where('id',  $input['item_id'])->first();

                //Creating Sales
                $sales = Sale::create(['slug' => $item->slug . rand(10,1000), 'item_id' => $input['item_id'], 'client_id' => $client->id, 'quantity' => 1, 'cost' => 1]);

                $result['msg'] = "Sale successfull";

                //Reducing credit

                Input::replace(array('credit' =>  $client->credit - 1));

                $client->update(Input::all());
            }
            else{
                $result['msg'] = "No credit on the card";
            }

        }

        return $result;
    }
}


