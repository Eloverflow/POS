<?php

namespace App\Http\Controllers\POS;

use App\Models\ERP\Inventory;
use App\Models\POS\Client;
use App\Models\POS\Command;
use App\Models\POS\CommandLine;
use App\Models\POS\Sale;
use App\Models\POS\SaleLine;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = 'Sales';

        /*Main table row to retrieve from DB*/
        $tableRows = Sale::all();
        /*Main table desired column to display*/
        $tableColumns = array('id', 'name');


        /*Child table name*/
        /* $tableChildName = "item";*/
        /*Child table rows*/
        /*$tableChildRows =  $tableRows->load($tableChildName);*/
        /*Child table desired column to display*/
        /*$tableChildColumns = array('name');*/

        /*$tableChild1 = array("name" => $tableChildName,"rows" => $tableChildRows, "columns" => $tableChildColumns);*/

        /*--------*/

        /*Child table name*/
        $tableChildName = "saleline";
        /*Child table rows*/
        $tableChildRows =  $tableRows->load($tableChildName);
        /*Child table desired column to display*/
        $tableChildColumns = array('type');

        $tableChild1 = array("name" => $tableChildName,"rows" => $tableChildRows, "columns" => $tableChildColumns);

        $tableChildren = array($tableChild1);

        return view('shared.list',compact('title','tableRows', 'tableColumns', 'tableChildren', 'tableChildRows', 'tableChildColumns'));
    }

    public function liste()
    {


        $title = 'Sales';

        /*Main table row to retrieve from DB*/
        $tableRows = SaleLine::all();
        /*Main table desired column to display*/

        /*Child table name*/
        $tableChildName = "sale";


        $table2ChildName = "item";

        /*Child table rows*/
        $tableRows->load($tableChildName)->load($table2ChildName);



       /* return $tableRows;*/

        /*var_dump($tableRows);*/

        return view('shared.list',compact('title','tableRows'));
    }


    public function menu()
    {
        return view('POS.Sale.menu');
    }

    public function payer(){

        $inputs = Input::except('_token');

        $result['inputs'] = $inputs;

        $result['msg'] = "";
        $result['success'] = "false";

        if(!empty($inputs)) {


            $client = Client::create(['slug' => rand(0, 99999999999)]);
            $result['msg'] = "Successfully created the client";

            if($client != ""){



                $sale = Sale::create(['client_id' => $client->id, 'sale_number' => Sale::all()->last()->sale_number + 1]);
                $result['sale_number'] = $sale->sale_number;

                $total = 0;

                $result['msg'] = "Successfully created the sale";

                if ($sale != "") {
                    foreach ($inputs as $input) {

                        if($input['quantity'] > 0)
                        {
                            $saleline = SaleLine::create(['sale_id' => $sale->id, 'item_id' => $input['id'], 'cost' => $input['size']['price'], 'quantity' => $input['quantity']]);
                            $result['msg'] = "Successfully created the sale line";

                            $total += $input['size']['price'] * $input['quantity'];

                            if($saleline == ""){
                                $result['msg'] = "Failed at sale line";
                                $result['success'] = "false";
                                break;
                            }
                            else{
                                $result['msg'] = "Succesfully recorded the sale";
                                $result['success'] = "true";

                                $inventory = Inventory::where('item_id', $input['id'])->first();

                                if($inventory != ""){
                                    //Reducing inventory
                                    Input::replace(array('quantity' =>  $inventory->quantity - $input['quantity']));
                                    $inventory->update(Input::all());

                                    $result['msg'] .= " - Succesfully reduced the inventory";
                                }
                                else
                                {
                                    $result['msg'] .= " - Unsuccessfully reduced the inventory";
                                }

                            }
                        }
                        else
                        {
                            $result['msg'] .= " - There was 0 quantity for this item : " . $input['name'];
                        }

                    }

                    $sale->total = $total;
                    $sale->save();
                }
                else{
                    $result['msg'] = "Failed at sale";
                }
            }
            else{
                $result['msg'] = "Failled at client";
            }
        }
        else{
            $result['msg'] = "No inputs or not enough";
        }







        return $result;
    }



    public function updateCommand()
    {
        $inputs = Input::except('_token');
/*
        var_dump($inputs);*/
/*
        $result['inputs'] = $inputs;*/

        $result['msg'] = "Messages";
        $result['success'] = "false";
        $result['commands'] = array();

        if (!empty($inputs)) {
/*
            foreach ($inputs['commands'] as $inputCommand) {*/

            for($clientNumber = 1; $clientNumber < count($inputs['commands']); $clientNumber++ ){

                $inputCommand = $inputs['commands'][$clientNumber];
/*
                var_dump($inputCommand);*/

                $client = Client::create(['slug' => rand(0, 99999999999)]);
                $result['msg'] .= " - Successfully created the client";

                $commandNumber = 0;
                $commands= Command::all()->last();
                if(!empty($commands))
                $commandNumber = $commands->command_number;

                $command = Command::create(['table_id' => $inputs['table'], 'client_id' => $client->id, 'command_number' => 1 + $commandNumber ]);
                // Command::all()->last()->command_number + 1

                if ($command != "") {
                    $result['msg'] .= " - Also created the command";
                    array_push($result['commands'], $command);


                    if(!empty($inputCommand['command_number'])){
                        //We update de command



                    }else{

                        /*We create a new command*/
                        foreach ($inputCommand['commandItems'] as $inputItem) {
                           /* var_dump($command);*/

                            $commandLine = CommandLine::create(['command_id' => $command->id, 'item_id' => $inputItem['id'], 'cost' => $inputItem['size']['price'], 'quantity' => $inputItem['quantity']]);

                            if($commandLine == ""){
                                $result['msg'] .= " - Failed at command line";
                                $result['success'] = "false";
                                break;
                            }
                            else
                            {
                                $result['msg'] .= " - Succesfully recorded the command line";
                                $result['success'] = "true";
                            }
                        }
                    }

                }


            }

        }












            /*$client = Client::create(['slug' => rand(0, 99999999999)]);
            $result['msg'] = "Successfully created the client";

            if ($client != "") {


               // $command = Command::create(['client_id' => $client->id, 'command_number' => Command::all()->last()->command_number + 1]);
                $command = Command::create(['table_id' => $inputs['table'], 'client_id' => $client->id, 'command_number' => 1]);
                $result['command_number'] = $command->command_number;



                if ($command != "") {

                    $result['msg'] = "Successfully created the command";

                    foreach ($inputs['commands'] as $input) {
                        $commandLine = CommandLine::create(['command_id' => $command->id, 'item_id' => $input['id'], 'cost' => $input['size']['price'], 'quantity' => $input['quantity']]);

                        if($commandLine == ""){
                            $result['msg'] = "Failed at command line";
                            $result['success'] = "false";
                            break;
                        }
                        else
                        {
                            $result['msg'] = "Succesfully recorded the command line";
                            $result['success'] = "true";
                        }
                    }
                }
                else{

                    $result['msg'] = "Failed at creating the command";
                }
            }
        }

        */

        return $result;
    }

}
