<?php

namespace App\Http\Controllers\POS;

use App\Models\ERP\Inventory;
use App\Models\POS\Client;
use App\Models\POS\Command;
use App\Models\POS\CommandLine;
use App\Models\POS\Plan;
use App\Models\POS\Sale;
use App\Models\POS\SaleLine;
use App\Models\POS\Setting;
use App\Models\POS\Table;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Activity;

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

    public function menuStart()
    {
        return view('POS.Sale.start');
    }

    public function menuSettings()
    {
        $menuSetting = Setting::all()->last();
        $plans = Plan::all();
        $timezones = json_decode(file_get_contents(app_path() . '/Helpers/timezones.json'), true);
        return view('POS.Sale.settings', compact('menuSetting', 'plans', 'timezones'));
    }

    public function applyMenuSettings()
    {

        $inputs = Input::except('_token');
        $menuSetting = Setting::create($inputs);
        $plans = Plan::all();
        $timezones = json_decode(file_get_contents(app_path() . '/Helpers/timezones.json'), true);

        return view('POS.Sale.settings', compact('menuSetting', 'plans', 'timezones'));
    }


    public function deleteBills()
    {

        $inputs = Input::except('_token');

        $result['inputs'] = $inputs;

        $result['msg'] = "";
        $result['success'] = "false";
        $result['saleLineIdMat'] = [];
        $result['saleIdArray'] = [];

        if (!empty($inputs)) {
            if (!empty($inputs['bills'])) {
                foreach ($inputs['bills'] as $bill) {


                    $billLineCommandId = '';
                    foreach ($bill as $billLine){

                        $billLineCommandId =  $billLine['command_id'];
                        break;
                    }/*
                   var_dump($bill[0]['command_id']);*/

                    $command = Command::where('id', $billLineCommandId)->first();

                    if (!empty($command)) {
                        $result['msg'] .= ' - Command Found';
                        $commandTable = Table::where('id', $command->table_id)->first();
                        if(!empty($commandTable['status']) && $commandTable['status'] == 3)
                        $commandTable['status'] = 2;
                        $commandTable->save();


                        $command->load('client');

                        if (!empty($command->client)) {
                            $result['msg'] .= ' - Client Found';


                            $sale = '';
                            foreach ($bill as $billLine) {
                                if(!empty($billLine['sale_id']))
                                    $sale = Sale::where('id', $billLine['sale_id'])->first();
                                break;
                            }

                            if(!empty($sale))
                            {
                                $result['msg'] .= ' - Sale Found';
                            }

                            /*We should eventually check if the bill can be deleted - Must not have been factured to the client*/
                            if(!empty($sale)) {
                                $result['success'] = "true";
                                foreach ($bill as $billLine) {

                                    if(!empty($billLine['saleLineId'])){
                                        $saleLine = SaleLine::where('id', $billLine['saleLineId'])->first();
                                        if (!empty($saleLine)) {
                                            $saleID = $billLine['sale_id'];
                                            if(empty($saleID)){
                                                $saleID = $sale->id;
                                            }
                                            $saleLine->delete();
                                            $result['msg'] .= ' - SaleLine deleted';
                                        }
                                    }
                                }

                                $sale->delete();
                            }
                        }
                    }
                }
            } else {
                $result['msg'] = "Inputs contain no Bills";
            }
        } else {
            $result['msg'] = "No inputs or not enough";
        }

        return $result;
    }

    public function updateBill()
    {


        $inputs = Input::except('_token');

        $result['inputs'] = $inputs;

        $result['msg'] = "";
        $result['success'] = "false";
        $result['saleLineIdMat'] = [];
        $result['saleIdArray'] = [];

        if (!empty($inputs)) {
            if (!empty($inputs['bills'])) {
                foreach ($inputs['bills'] as $bill) {


                    $billLineCommandId = '';
                    foreach ($bill as $billLine){

                        $billLineCommandId =  $billLine['command_id'];
                        break;
                    }/*
                   var_dump($bill[0]['command_id']);*/

                    $command = Command::where('id', $billLineCommandId)->first();

                    if (!empty($command)) {
                        $result['msg'] .= ' - Command Found';
                        $commandTable = Table::where('id', $command->table_id)->first();
                        if(!empty($commandTable['status']) && $commandTable['status'] == 2)
                        $commandTable['status'] = 3;
                        $commandTable->save();


                        $command->load('client');

                        if (!empty($command->client)) {
                            $result['msg'] .= ' - Client Found';


                            $sale = '';
                            foreach ($bill as $billLine) {
                                if(!empty($billLine['sale_id']))
                                    $sale = Sale::where('id', $billLine['sale_id'])->first();
                                break;
                            }

                            if(!empty($sale))
                            {
                                $result['msg'] .= ' - Sale Found';
                                $sale->update(['client_id' => $command['client']['id'], 'total' => $command['total'], 'subTotal' => $command['subTotal']]);
                                $sale->save();
                            }
                            else{
                                $saleNumber = Sale::all()->last();
                                if(empty($saleNumber)){
                                    $saleNumber = 0;
                                }
                                else{
                                    $saleNumber = $saleNumber->sale_number;
                                }
                                $sale = Sale::create(['client_id' => $command['client']['id'], 'sale_number' => $saleNumber, 'total' => $command['total'], 'subTotal' => $command['subTotal']]);

                                if (!empty($sale)) {
                                    $result['msg'] .= ' - Sale Created';
                                }
                            }
                            array_push($result['saleLineIdMat'], []);

                            if (!empty($sale)) {
                                $result['success'] = "true";
                                array_push($result['saleIdArray'], $sale->id);
                                foreach ($bill as $billLine) {

                                    if(!empty($billLine['extras']))
                                        $billLine['extras'] = json_encode($billLine['extras']);
                                    else
                                        $billLine['extras'] = "";

                                    if(!empty($billLine['saleLineId'])){
                                        $saleLine = SaleLine::where('id', $billLine['saleLineId'])->first();
                                        if (!empty($saleLine)) {
                                            $saleID = $billLine['sale_id'];
                                            if(empty($saleID)){
                                                $saleID = $sale->id;
                                            }
                                            $saleLine->update(['sale_id' => $saleID, 'command_id' => $billLine['command_id'], 'command_line_id' => $billLine['command_line_id'], 'quantity' => $billLine['quantity'], 'extras' => $billLine['extras']]);
                                            $saleLine->save();
                                            $result['msg'] .= ' - SaleLine Updated';
                                        }
                                    }
                                    else{

                                        $saleLine = SaleLine::create(['sale_id' => $sale->id, 'item_id' => $billLine['id'], 'command_id' => $billLine['command_id'], 'command_line_id' => $billLine['command_line_id'], 'quantity' => $billLine['quantity'], 'cost' => $billLine['size']['price'] , 'size' => $billLine['size']['name'], 'taxes' => Setting::all()->last()['taxes'], 'extras' => $billLine['extras']]);
                                        if (!empty($saleLine)) {
                                            $result['msg'] .= ' - SaleLine Created';
                                            array_push($result['saleLineIdMat'][count($result['saleLineIdMat'])- 1] ,$saleLine->id);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $result['msg'] = "Inputs contain no Bills";
            }
        } else {
            $result['msg'] = "No inputs or not enough";
        }

        return $result;
    }


    public function getCommand()
    {
        $inputs = Input::except('_token');


        $result['msg'] = "Messages\n ";
        $result['success'] = "false";
        $result['commands'] = array();


        $command = Command::where('table_id', $inputs['table']['id'])->where('status', '<>',  '2')->get();

        if($command != "")
        {
            $result['commands'] = $command->load('commandline');
            $result['success'] = "true";
        }


        return $result;
        //If the post isn't empty
    }


    public function getBills()
    {
        $inputs = Input::except('_token');


        $result['msg'] = "Messages\n ";
        $result['success'] = "false";
        $result['bills'] = [];

        foreach ($inputs['commandsId'] as $commandsId){
            $saleLines = SaleLine::where('command_id', $commandsId)->get();

            foreach ($saleLines as $saleLine){
                if($saleLine != "")
                {
                    if(empty($result['bills'][$saleLine->sale_id])){
                        $result['bills'][$saleLine->sale_id ] = [];
                    }
                    array_push($result['bills'][$saleLine->sale_id], $saleLine);

                    $result['success'] = "true";
                }
            }
        }

        return $result;
        //If the post isn't empty
    }


    public function updateCommand()
    {

        $inputs = Input::except('_token');
/*
        var_dump($inputs);*/
/*
        $result['inputs'] = $inputs;*/

        $result['msg'] = "Messages\n ";
        $result['success'] = "false";
        $result['commands'] = array();
        $result['commandLine'] = array();
        $result['commandLineIdMat'] = [];
        $changingTableStatus = false;

        //If the post isn't empty
        if (!empty($inputs)) {
/*
            foreach ($inputs['commands'] as $inputCommand) {*/

            //Foreach (client aka command) inside the Post
            for($clientNumber = 1; $clientNumber < count($inputs['commands']); $clientNumber++ ){

                $result['msg'] .= "Client #" . $clientNumber . " :\n";

                array_push($result['commandLineIdMat'], []);

                $inputCommand = $inputs['commands'][$clientNumber];

                /*If the command Posted contain a commmand_number it mean that it already exist, so we gota update it instead of create it */
                if(!empty($inputCommand['command_number'])){
                    $command = Command::where('command_number', $inputCommand['command_number'])->first();

                    /*We gotta update the command too now*/
                    if(!empty($inputCommand['notes']))
                    {
                        $inputCommand['notes'] = json_encode($inputCommand['notes']);
                    }

                    if(!empty($inputCommand['notes']))
                        $command['notes'] = $inputCommand['notes'];
                    else
                        $command['notes'] = "";

                    /*We gotta update the command too now*/
                    if(!empty($inputCommand['extras']))
                    {
                        $inputCommand['extras'] = json_encode($inputCommand['extras']);
                    }

                    if(!empty($inputCommand['extras']))
                        $command['extras'] = $inputCommand['extras'];
                    else
                        $command['extras'] = "";


                    if(!empty($inputCommand['status']))
                        $command['status'] = $inputCommand['status'];
                    else
                        $command['status'] = "";


                    if($command['status'] == 2)
                        $changingTableStatus = true;
                    else
                        $changingTableStatus = false;

                    $command->update();

                    $command->save();


/*
                    $command = $command[0];*/

                    /*If we found the command*/
                    if ($command != "") {
                        $result['msg'] .= " - Found the command";
                        array_push($result['commands'], $command);
/*
                        var_dump($command);*/
                        $commandLines = CommandLine::where('command_id', $command['id'])->get();

                        if(count($commandLines) > count($inputCommand['commandItems']))
                        {
                            $result['msg'] .= " - Removing deleted commands lines";

                            foreach ($commandLines as $commandLine) {
                                $isMissing = true;

                                foreach ($inputCommand['commandItems'] as $inputItem) {
                                    if($commandLine['item_id'] == $inputItem['id'] && $commandLine['size'] == $inputItem['size']['name'])
                                        $isMissing = false;
                                }

                                if($isMissing)
                                {
                                    $commandLine->delete();
                                    $result['msg'] .= " - Deleting a command line";
                                }
                            }
                        }

                        //We update de command
                        foreach ($inputCommand['commandItems'] as $inputItem) {
                            $commandLine = CommandLine::where('command_id', $command->id)->where('item_id', $inputItem['id'])->where('size', $inputItem['size']['name']);
/*
                            var_dump($commandLine);*/


                            if(!empty($commandLine->first())){
                                $result['msg'] .= " - Succeeded at finding the command line";/*
                                $result['inputItem'] = $inputItem;*/
                                $commandLine->update(['cost' => $inputItem['size']['price'], 'quantity' => $inputItem['quantity'], 'status'=>$inputItem['status'], 'notes' => json_encode($inputItem['notes']), 'extras' => json_encode($inputItem['extras'])]);
                                $result['msg'] .= " - Command line normally updated";
                                array_push($result['commandLineIdMat'][count($result['commandLineIdMat'])-1], $commandLine->first()->id);
                            }
                            else{
                                $result['msg'] .= " - Failed at finding the command line";
                                $commandLine = CommandLine::create(['command_id' => $command->id, 'item_id' => $inputItem['id'], 'size' => $inputItem['size']['name'], 'cost' => $inputItem['size']['price'], 'status'=>$inputItem['status'],  'quantity' => $inputItem['quantity'], 'notes' => json_encode($inputItem['notes']), 'extras' => json_encode($inputItem['extras']) ]);

                                if($commandLine == ""){
                                    $result['msg'] .= " - Failed at recording command line";
                                    $result['success'] = "false";
                                    break;
                                }
                                else
                                {
                                    $result['msg'] .= " - Successfully recorded the command line";
                                    array_push($result['commandLineIdMat'][count($result['commandLineIdMat'])-1], $commandLine->id);
                                    $result['success'] = "true";
                                }
                            }

                        }


                    }
                }
                else{
                    /* var_dump($inputCommand); */

                    $client = Client::create(['slug' => rand(0, 99999999999)]);
                    $result['msg'] .= " - Successfully created the client";

                    $commandNumber = 0;
                    $commands= Command::all()->last();
                    if(!empty($commands))
                    $commandNumber = $commands->command_number;


                    $notes = "";
                    if(!empty($inputCommand['notes']))
                    $notes = json_encode($inputCommand['notes']);

                    $extras = "";
                    if(!empty($inputCommand['extras']))
                        $extras = json_encode($inputCommand['extras']);

                    $command = Command::create([
                        'table_id' => $inputs['table']['id'],
                        'client_id' => $client->id,
                        'command_number' => 1 + $commandNumber,
                        'status' => 1,
                        'notes' => $notes,
                        'extras' => $extras
                    ]);
                    // Command::all()->last()->command_number + 1

                    if ($command != "") {
                        $result['msg'] .= " - Also created the command";
                        /*We can now change the table status*/
                        $commandTable = Table::where('id', $inputs['table']['id'])->first();
                        $commandTable['status'] = 2;
                        $commandTable->save();

                        array_push($result['commands'], $command);


                        if(!empty($inputCommand['command_number'])){
                            //We update de command
                            foreach ($inputCommand['commandItems'] as $inputItem) {/*
                                $commandLine = CommandLine::findOrNew($inputItem['id']);*/

                                $commandLine = CommandLine::where('command_id', $command->id)->where('item_id', $inputItem['id'])->where('size', $inputItem['size']['name']);


                                if($commandLine != ""){
                                    array_push($result['commandLineIdMat'][count($result['commandLineIdMat'])-1], $commandLine->first()->id);

                                    $result['msg'] .= " - Succeeded at finding the command line";

                                    //Serialization of notes
                                    $inputItem['notes'] = json_encode($inputItem['notes']);

                                    //Serialization of extras
                                    $inputItem['extras'] = json_encode($inputItem['extras']);

                                    $commandLine->update($inputItem);
                                    $result['msg'] .= " - Command line normally updated";
                                }
                                else{
                                    $result['msg'] .= " - Failed at finding the command line";

                                    $notes = "";
                                    if(!empty($inputCommand['notes']))
                                        $notes = json_encode($inputItem['notes']);

                                    $extras = "";
                                    if(!empty($inputCommand['extras']))
                                        $extras = json_encode($inputItem['extras']);

                                    $commandLine = CommandLine::create(['command_id' => $command->id, 'item_id' => $inputItem['id'], 'status'=>$inputItem['status'], 'size' => $inputItem['size']['name'], 'cost' => $inputItem['size']['price'], 'quantity' => $inputItem['quantity'], 'notes' => $notes, 'extras' => $extras]);

                                    if($commandLine == ""){
                                        $result['msg'] .= " - Failed at recording command line";
                                        $result['success'] = "false";
                                        break;
                                    }
                                    else
                                    {
                                        $result['msg'] .= " - Successfully recorded the command line";
                                        array_push($result['commandLineIdMat'][count($result['commandLineIdMat'])-1], $commandLine->id);
                                        $result['success'] = "true";
                                    }
                                }

                            }


                        }else{

                            /*We create a new command*/
                            foreach ($inputCommand['commandItems'] as $inputItem) {
                                /* var_dump($command);*/


                                $commandLine = CommandLine::create(['command_id' => $command->id, 'item_id' => $inputItem['id'],  'status'=>$inputItem['status'], 'size' => $inputItem['size']['name'], 'cost' => $inputItem['size']['price'], 'quantity' => $inputItem['quantity'], 'notes' => json_encode($inputItem['notes']), 'extras' => json_encode($inputItem['extras'])]);
                                array_push($result['commandLineIdMat'][count($result['commandLineIdMat'])-1], $commandLine->id);

                                if($commandLine == ""){
                                    $result['msg'] .= " - Failed at command line";
                                    $result['success'] = "false";
                                    break;
                                }
                                else
                                {
                                    $result['msg'] .= " - Successfully recorded the command line";
                                    $result['success'] = "true";
                                }
                            }
                        }

                    }

                }




            }

        }

        if($changingTableStatus){
            $table = Table::where('id', $inputs['table']['id'])->first();
            $table['status'] = 1;
            $table->save();
        }
        return $result;
    }

}
