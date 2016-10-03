<?php

use Illuminate\Database\Seeder;


use App\Models\ERP\Extra;
use App\Models\ERP\ExtraItemType;
use App\Models\ERP\Item;
use App\Models\ERP\ItemType;
use App\Models\ERP\OrderLine;
use App\Models\ERP\Supplier;
use App\Models\ERP\Order;
use App\Models\ERP\Inventory;
use App\Models\Addons\Rfid\TableRfid;
use App\Models\Addons\Rfid\TableRfidRequest;
use App\Models\POS\Client;
use App\Models\POS\Command;
use App\Models\POS\CommandLine;
use App\Models\POS\Filter;
use App\Models\POS\FilterItem;
use App\Models\POS\FilterItemType;
use App\Models\POS\Sale;
use App\Models\POS\SaleLine;
use App\Models\POS\Plan;
use App\Models\POS\Setting;
use App\Models\POS\Table;
use App\Models\POS\Day_Availability;
use App\Models\POS\Availability;
use App\Models\Auth\User;
use App\Models\POS\Employee;
use App\Models\POS\WorkTitle;
use App\Models\POS\Schedule;
use App\Models\POS\Day_Schedules;
use App\Models\POS\Punch;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(ItemTypesTableSeeder::class);/*
        $this->call(ItemFieldListsTableSeeder::class);*/
        $this->call(ItemsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderLinesTableSeeder::class);
        //$this->call(ItemTypeBeersTableSeeder::class);
        //$this->call(ItemTypeDrinksTableSeeder::class);
        $this->call(InventoriesTableSeeder::class);
        $this->call(RfidTableSeeder::class);
        $this->call(RfidTableRequestSeeder::class);
        //$this->call(RfidTableBeerSeeder::class);

        $this->call(WorkTitleSeeder::class);
        $this->call(EmployeeSeeder::class);

        $this->call(AvailabilityTableSeeder::class);
        $this->call(Day_AvailabilityTableSeeder::class);

        $this->call(SchedulesTableSeeder::class);
        $this->call(Day_SchedulesTableSeeder::class);

        $this->call(ClientSeeder::class);

        $this->call(PunchesTableSeeder::class);

        $this->call(PlanSeeder::class);
        $this->call(TableSeeder::class);
        $this->call(CommandSeeder::class);
        $this->call(CommandLineSeeder::class);
        $this->call(SaleSeeder::class);
        $this->call(SaleLineSeeder::class);
        $this->call(MenuSettingsTableSeeder::class);
        $this->call(ExtraSeeder::class);
        $this->call(ExtraItemTypeSeeder::class);
        $this->call(FilterSeeder::class);
        $this->call(FilterItemTypeSeeder::class);
        $this->call(FilterItemSeeder::class);

    }
}



class MenuSettingsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('settings')->delete();

        Setting::create(['taxes' => json_encode("[{value: 0.05,name: 'TPS' },{value: 0.09975,name: 'TVQ'}]"), 'plan_id'=>1, 'use_time_24'=>true, 'language'=>'fr', 'timezone'=>'Eastern Standard Time', 'daylight'=>true, 'ipaddress'=>'666.666.666.666', 'use_email'=>true]);

        $this->command->info('Menu Settings table seeded!');
    }

}


class PunchesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('punches')->delete();

        Punch::create(['employee_id' => 1, 'startTime' => '2016-06-06 15:00:00', 'endTime' => '2016-06-06 19:00:00', 'work_title_id' => 1]);

        $this->command->info('Disponibilities table seeded!');
    }

}

class AvailabilityTableSeeder extends Seeder {

    public function run()
    {
        DB::table('availability')->delete();

        Availability::create(['name' => 'Dispo 1', 'employee_id' => 1]);

        $this->command->info('availability table seeded!');
    }

}

class Day_AvailabilityTableSeeder extends Seeder {

    public function run()
    {
        DB::table('day_availability')->delete();

        Day_Availability::create(['availability_id' => 1,
            'day_number' => 0,
            'startTime' => date('15:00:00'),
            'endTime' => date('17:00:00')
        ]);

        Day_Availability::create(['availability_id' => 1,
            'day_number' => 0,
            'startTime' => date('18:00:00'),
            'endTime' => date('19:55:00')
        ]);

        Day_Availability::create(['availability_id' => 1,
            'day_number' => 3,
            'startTime' => date('20:00:00'),
            'endTime' => date('03:00:00')
        ]);
        $this->command->info('Day availability table seeded!');
    }

}


class SchedulesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('schedules')->delete();
        Schedule::create(['name' => 'Schedules 1', 'startDate' => '2016-06-05', 'endDate' => '2016-06-11']);

        $this->command->info('Schedules table seeded!');
    }

}

class Day_SchedulesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('day_schedules')->delete();

        Day_Schedules::create(['schedule_id' => 1,
            'employee_id' => 1,
            'startTime' => date('2016-06-06 15:00:00'),
            'endTime' => date('2016-06-06 17:00:00')
        ]);

        Day_Schedules::create(['schedule_id' => 1,
            'employee_id' => 1,
            'startTime' => date('2016-06-07 18:00:00'),
            'endTime' => date('2016-06-07 19:55:00')
        ]);

        Day_Schedules::create(['schedule_id' => 1,
            'employee_id' => 1,
            'startTime' => date('2016-06-09 20:00:00'),
            'endTime' => date('2016-06-10 03:00:00')
        ]);
        $this->command->info('Day Schedules table seeded!');
    }

}



class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['name' => 'Labatt', 'email' => 'labatt@email.com', 'password' => 'pass12345']);
        User::create(['name' => 'Jean Fortin-Moreau', 'email' => 'jfortin-moreau@outlook.com', 'password' => 'inpensable', 'remember_token' => 'ozk5AuCDzT6yoE1AdNiQ0KlaYc76bMzNLSoOWF8kVUj36vIi8H3V3bU2xbm3']);
        User::create(['name' => 'root', 'email' => 'maype.isaelblais@gmail.com', 'password' => 'dollaswag']);
        User::create(['name' => 'Visiteur(es) Adncomm', 'email' => 'visiteur@adncomm.com', 'password' => 'ItWasAdncomm1337!', 'remember_token' => 'l6JMhYJSwbQj8791LCAhPdkrryYMQQkjbwkqd13MhgEeAyUj3yAfoEXvzmTL']);
        User::create(['name' => 'user_employee', 'email' => 'test-mflow@yopmail.com', 'password' => '11']);
        User::create(['name' => 'Visiteur', 'email' => 'visiteur@mirageflow.com', 'password' => 'Visiteur!']);
        User::create(['name' => 'Alex Breton', 'email' => 'alex.breton@hotmail.co.uk', 'password' => '@lexBreton']);


        $this->command->info('Users table seeded!');
    }

}

class SuppliersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('suppliers')->delete();

        Supplier::create(['name' => 'Labatt', 'slug' => 'labatt']);
        Supplier::create(['name' => 'Alexandre Keith', 'slug' => 'alexandre_keith']);

        $this->command->info('Suppliers table seeded!');
    }

}

class OrdersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('orders')->delete();

        Order::create(['supplier_id' => '1', 'command_number' => '1000141']);
        Order::create(['supplier_id' => '1', 'command_number' => '1000148']);

        $this->command->info('Orders table seeded!');
    }

}

class OrderLinesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('order_lines')->delete();

        OrderLine::create(['quantity' => '5', 'order_id' => '1', 'item_id' => '1']);
        OrderLine::create(['quantity' => '3', 'order_id' => '1', 'item_id' => '2']);

        $this->command->info('Order Line table seeded!');
    }

}

class ItemTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_types')->delete();

        ItemType::create(['type' => 'Bière', 'field_names' => 'brand,style,percent ', 'size_names' => 'Verre,Pinte,Pichet,Baril', 'slug' => 'beer']);
        ItemType::create(['type' => 'Drink', 'field_names' => 'flavour,color,author,percent', 'size_names' => 'Petit,Moyen,Gros', 'slug' => 'drink']);
        ItemType::create(['type' => 'Poutine', 'field_names' => 'sauce, cheese, meet', 'size_names' => 'Petite,Moyenne,Grosse', 'slug' => 'Poutine']);
        ItemType::create(['type' => 'Grilled Cheeze', 'field_names' => 'bread, cheese', 'size_names' => 'Simple,Double', 'slug' => 'grilled-cheeze']);
        ItemType::create(['type' => 'Nachos', 'field_names' => 'chips,cheese,meet ', 'size_names' => 'Assiete,Plateau', 'slug' => 'nachos']);

        $this->command->info('ItemTypes table seeded!');
    }

}



class ItemsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('items')->delete();

        /* The item type will define their item_field_name  */
        Item::create([
            'item_type_id' => '1',
            'name' => 'Keith',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem.',
            'slug' => 'keith',
            'img_id' => 'Alexander Keith.jpg',
            'custom_fields_array' => json_encode(array('Alexander Keith','Red','5'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('6.25','8.12','16.75','175.99' ), JSON_UNESCAPED_UNICODE )]);

        Item::create([
            'item_type_id' => '1',
            'name' => 'Blue', 'description' => 'Tous mes sens sont émus d\'une volupté douce et pure.',
            'slug' => 'blue',
            'img_id' => 'Labatt Blue.jpg',
            'custom_fields_array' => json_encode(array('Labatt','Dry','5.6'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('5.25','7.15','14.95','135.98' ), JSON_UNESCAPED_UNICODE)]);


        Item::create(['item_type_id' => '1',
            'name' => 'Coorslight',
            'description' => 'Voyez ce jeu exquis wallon, de graphie en kit mais bref.',
            'slug' => 'coorslight',
            'img_id' => 'Labatt Blue.jpg',
            'custom_fields_array' => json_encode(array('Coors','Light','4.5'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('5.25','7.15','14.95','135.98' ), JSON_UNESCAPED_UNICODE)]);


        Item::create([
            'item_type_id' => '2',
            'name' => 'DUniversal',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ',
            'slug' => 'mydrinkname',
            'img_id' => 'drink.jpg',
            'custom_fields_array' => json_encode(array('Sour','green','Jino', '20'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('2.25','5.00','7.95' ), JSON_UNESCAPED_UNICODE)]);

        Item::create([
            'item_type_id' => '2',
            'name' => 'Vodka Jus d\'orange',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.',
            'slug' => 'Vodka-jus-orange',
            'img_id' => '',
            'custom_fields_array' => json_encode(array('Warming','Orange','Some Guy', '25'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('3.25','5.50','8.35' ), JSON_UNESCAPED_UNICODE)]);

        Item::create([
            'item_type_id' => '3',
            'name' => 'Poutine Côte Levée',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.',
            'slug' => 'poutine-cote-leve',
            'img_id' => '',
            'custom_fields_array' => json_encode(array('BBQ','Montery Jack','Côte Levée'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('4.50','6.40','8.15' ), JSON_UNESCAPED_UNICODE)]);

        Item::create([
            'item_type_id' => '4',
            'name' => 'Grilled cheeze bacon',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.',
            'slug' => 'grilled-cheeze-bacon',
            'img_id' => '',
            'custom_fields_array' => json_encode(array('White','4 Fromage'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('3.90','6.00' ), JSON_UNESCAPED_UNICODE)]);


        Item::create([
            'item_type_id' => '5',
            'name' => 'Nachos Chili Bacon',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.',
            'slug' => 'nachos-chili-bacon',
            'img_id' => '',
            'custom_fields_array' => json_encode(array('Nachos','4 Fromage', 'Bacon'), JSON_UNESCAPED_UNICODE),
            'size_prices_array' => json_encode(array('4.95','7.70' ), JSON_UNESCAPED_UNICODE)]);

        $this->command->info('Items table seeded!');
    }

}

class InventoriesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('inventories')->delete();

        Inventory::create(['item_id' => '1', 'quantity' => '100', 'slug' => 'keith']);
        Inventory::create(['item_id' => '2', 'quantity' => '50',  'slug' => 'blue']);

        $this->command->info('Inventories table seeded!');
    }

}

class RfidTableSeeder extends Seeder {

    public function run()
    {
        DB::table('rfid_tables')->delete();

        TableRfid::create(['flash_card_hw_code' => 'b8:27:eb:d7:b7:7b', 'name' => 'Poste 1', 'description' => '100', 'beer1_item_id' => '2', 'slug' => 'poste1']);
        TableRfid::create(['flash_card_hw_code' => 'b8:27:eb:d7:b7:7c', 'name' => 'Poste 2', 'description' => '100', 'beer1_item_id' => '3', 'beer2_item_id' => '1', 'slug' => 'poste2']);
        TableRfid::create(['flash_card_hw_code' => '2', 'name' => 'Poste 2', 'description' => '50', 'slug' => 'poste2']);
        TableRfid::create(['flash_card_hw_code' => '3', 'name' => 'Poste 3', 'description' => '50', 'slug' => 'poste3']);
        TableRfid::create(['flash_card_hw_code' => '4', 'name' => 'Poste 4', 'description' => '50', 'slug' => 'poste4']);

        $this->command->info('rfid_tables table seeded!');
    }

}

class RfidTableRequestSeeder extends Seeder {

    public function run()
    {
        DB::table('rfid_table_requests')->delete();

        TableRfidRequest::create(['id' => '1', 'flash_card_hw_code' => '1', 'rfid_card_code' => 'ad1213213']);

        $this->command->info('rfid_table_requests table seeded!');
    }

}

class EmployeeSeeder extends Seeder {

    public function run()
    {
        DB::table('employees')->delete();

        Employee::create([
            'firstName' => 'Isael',
            'lastName' => 'Blais',
            'streetAddress' => 'Chapdelaine',
            'phone' => '5818886704',
            'city' => 'Quebec',
            'state' => 'Quebec',
            'pc' => 'g0r3a0',
            'nas' => '123456789',
            'userId' => 1,
            'bonusSalary' => 1,
            'birthDate' => date('2016-01-01'),
            'hireDate' => date('2016-01-01')
        ]);
        Employee::create([
            'firstName' => 'Jean',
            'lastName' => 'Fortin-Moreau',
            'streetAddress' => 'Place Philippe',
            'phone' => 'None',
            'city' => 'Quebec',
            'state' => 'Quebec',
            'pc' => 'g0w0w3',
            'nas' => '123456789',
            'userId' => 2,
            'bonusSalary' => 1,
            'birthDate' => date('2016-01-01'),
            'hireDate' => date('2016-01-01')
        ]);
        Employee::create([
            'firstName' => 'John',
            'lastName' => 'Mccormick',
            'streetAddress' => 'streetAddress',
            'phone' => 'none',
            'city' => 'Quebec',
            'state' => 'Quebec',
            'pc' => 'a1a1a1',
            'nas' => '123456789',
            'userId' => 5,
            'bonusSalary' => 1,
            'birthDate' => date('2016-01-01'),
            'hireDate' => date('2016-01-01')
        ]);
        $this->command->info('People table seeded!');
    }

}


class WorkTitleSeeder extends Seeder {
    public function run()
    {
        DB::table('work_titles')->delete();

        WorkTitle::create([
            'name' => 'Barmaid',
            'baseSalary' => 12,
        ]);
        WorkTitle::create([
            'name' => 'Livreur',
            'baseSalary' => 12,
        ]);
        WorkTitle::create([
            'name' => 'Plongeur',
            'baseSalary' => 12,
        ]);
        WorkTitle::create([
            'name' => 'Cuisinier',
            'baseSalary' => 12,
        ]);
    }
}


class ClientSeeder extends Seeder {

    public function run()
    {
        DB::table('clients')->delete();

        Client::create(['credit' => 10, 'rfid_card_code' => '2784390787',  'slug' => '2784390787']);
        Client::create(['credit' => 20, 'rfid_card_code' => '2784390788',  'slug' => '2784390788']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000001']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000002']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000003']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000004']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000005']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000006']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000007']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000008']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000009']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000010']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000011']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000012']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000013']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000014']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000015']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000016']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000017']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000018']);
        Client::create(['credit' => 0, 'rfid_card_code' => '',  'slug' => 'user-00000019']);

        $this->command->info('clients table seeded!');
    }

}


class PlanSeeder extends Seeder {

    public function run()
    {
        DB::table('plans')->delete();

        for($i = 1; $i < 2; $i++){
            Plan::create(['id' => $i, 'name' => "Plan No. " . $i, 'nbFloor' => 2, 'wallPoints' => "587:68,696:137,1161:143,1166:364,695:362,535:484,301:547,301:749,5:760,5:586,5:5,400:5"]);
        }

        $this->command->info('plans table seeded!');
    }

}

class TableSeeder extends Seeder {

    public function run()
    {
        $preDoneTable = array(array('id' => '1','type' => 'tbl','tblNumber' => '1','noFloor' => '0','xPos' => '29','yPos' => '314','angle' => '0.536766rad','plan_id' => '1','status' => '2','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '2','type' => 'tbl','tblNumber' => '2','noFloor' => '0','xPos' => '157','yPos' => '296','angle' => '0.536766rad','plan_id' => '1','status' => '3','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '3','type' => 'tbl','tblNumber' => '3','noFloor' => '0','xPos' => '35','yPos' => '214','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '4','type' => 'tbl','tblNumber' => '4','noFloor' => '0','xPos' => '173','yPos' => '194','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '5','type' => 'tbl','tblNumber' => '5','noFloor' => '0','xPos' => '43','yPos' => '120','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '6','type' => 'tbl','tblNumber' => '6','noFloor' => '0','xPos' => '149','yPos' => '27','angle' => '1.56547rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '7','type' => 'tbl','tblNumber' => '7','noFloor' => '0','xPos' => '244','yPos' => '26','angle' => '1.59723rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '8','type' => 'tbl','tblNumber' => '8','noFloor' => '0','xPos' => '923','yPos' => '199','angle' => '1.58034rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:26:26'),array('id' => '9','type' => 'tbl','tblNumber' => '9','noFloor' => '0','xPos' => '1035','yPos' => '198','angle' => '1.57802rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:26:26'),array('id' => '10','type' => 'tbl','tblNumber' => '10','noFloor' => '0','xPos' => '39','yPos' => '650','angle' => '0.0108279rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '11','type' => 'tbl','tblNumber' => '11','noFloor' => '0','xPos' => '172','yPos' => '647','angle' => '-0.058568rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '12','type' => 'tbl','tblNumber' => '12','noFloor' => '0','xPos' => '168','yPos' => '552','angle' => '-0.0398922rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '13','type' => 'tbl','tblNumber' => '13','noFloor' => '0','xPos' => '41','yPos' => '555','angle' => '-0.0263365rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '14','type' => 'tbl','tblNumber' => '14','noFloor' => '0','xPos' => '42','yPos' => '458','angle' => '-0.0342332rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '15','type' => 'tbl','tblNumber' => '15','noFloor' => '0','xPos' => '179','yPos' => '449','angle' => '-0.0985259rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '16','type' => 'tbl','tblNumber' => '16','noFloor' => '0','xPos' => '314','yPos' => '398','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '17','type' => 'tbl','tblNumber' => '17','noFloor' => '0','xPos' => '418','yPos' => '358','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '18','type' => 'tbl','tblNumber' => '18','noFloor' => '0','xPos' => '518','yPos' => '315','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '19','type' => 'tbl','tblNumber' => '19','noFloor' => '0','xPos' => '550','yPos' => '221','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '20','type' => 'tbl','tblNumber' => '20','noFloor' => '0','xPos' => '565','yPos' => '114','angle' => '0.56906rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '21','type' => 'tbl','tblNumber' => '21','noFloor' => '0','xPos' => '441','yPos' => '56','angle' => '0.332999rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '22','type' => 'tbl','tblNumber' => '22','noFloor' => '0','xPos' => '323','yPos' => '10','angle' => '0.28873rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'),array('id' => '23','type' => 'plc','tblNumber' => '23','noFloor' => '0','xPos' => '784','yPos' => '222','angle' => '0','plan_id' => '1','status' => '1','created_at' => '2016-05-31 16:26:26','updated_at' => '2016-05-31 16:26:26'),array('id' => '24','type' => 'plc','tblNumber' => '24','noFloor' => '1','xPos' => '29','yPos' => '314','angle' => '0.536766rad','plan_id' => '1','status' => '1','created_at' => '2016-05-31 11:33:42','updated_at' => '2016-05-31 16:24:36'));
        DB::table('tables')->delete();

        foreach ($preDoneTable as $table){
            Table::create($table);
        }

        /*for($i = 1; $i < 23; $i++){
            Table::create(['id' => $i, 'type' => 'tbl', 'tblNumber' => $i, 'noFloor' => 0, 'xPos' => $i, 'yPos' => ($i*2),'angle' => '0.536766rad','plan_id' => 1, 'status' => '1']);
        }*/

        $this->command->info('tables table seeded!');
    }

}



class CommandSeeder extends Seeder {

    public function run()
    {
        DB::table('commands')->delete();

        $commands = array(
            array('id' => '1','notes' => '[{"note":"Ne pas faire"}]','status' => '1','command_number' => '1','table_id' => '1','client_id' => '2','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:33:43'),
            array('id' => '2','notes' => '','status' => '1','command_number' => '2','table_id' => '1','client_id' => '3','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:33:43'),
            array('id' => '3','notes' => '','status' => '1','command_number' => '3','table_id' => '2','client_id' => '4','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:33:53'),
            array('id' => '4','notes' => '','status' => '1','command_number' => '4','table_id' => '2','client_id' => '5','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:33:53')
        );

        foreach ($commands as $table){
            Command::create($table);
        }

        $this->command->info('commands table seeded!');
    }

}

class CommandLineSeeder extends Seeder {

    public function run()
    {
        DB::table('command_lines')->delete();

        $command_lines = array(
            array('id' => '1','command_id' => '1','item_id' => '1','size' => 'Verre','quantity' => '1','notes' => '[]','cost' => '6.25','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '2','command_id' => '1','item_id' => '2','size' => 'Pinte','quantity' => '1','notes' => '[]','cost' => '7.15','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '3','command_id' => '1','item_id' => '3','size' => 'Pinte','quantity' => '1','notes' => '[]','cost' => '7.15','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '4','command_id' => '2','item_id' => '1','size' => 'Verre','quantity' => '1','notes' => '[]','cost' => '6.25','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '5','command_id' => '2','item_id' => '2','size' => 'Pinte','quantity' => '1','notes' => '[]','cost' => '7.15','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '6','command_id' => '2','item_id' => '3','size' => 'Pichet','quantity' => '1','notes' => '[]','cost' => '14.95','created_at' => '2016-06-10 18:33:43','updated_at' => '2016-06-10 18:34:21'),
            array('id' => '7','command_id' => '3','item_id' => '1','size' => 'Verre','quantity' => '1','notes' => '[]','cost' => '6.25','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:34:19'),
            array('id' => '8','command_id' => '3','item_id' => '2','size' => 'Pinte','quantity' => '1','notes' => '[]','cost' => '7.15','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:34:19'),
            array('id' => '9','command_id' => '4','item_id' => '1','size' => 'Verre','quantity' => '1','notes' => '[]','cost' => '6.25','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:34:19'),
            array('id' => '10','command_id' => '4','item_id' => '2','size' => 'Pinte','quantity' => '1','notes' => '[]','cost' => '7.15','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:34:19'),
            array('id' => '11','command_id' => '4','item_id' => '3','size' => 'Pichet','quantity' => '1','notes' => '[]','cost' => '14.95','created_at' => '2016-06-10 18:33:53','updated_at' => '2016-06-10 18:34:19')
        );


        foreach ($command_lines as $table){
            $table['status']=2;
            CommandLine::create($table);
        }

        $this->command->info('command_lines table seeded!');
    }

}

class SaleSeeder extends Seeder {

    public function run()
    {
        DB::table('sales')->delete();

        $sales = array(
            array('id' => '1','cancelled' => '0','sale_number' => '0','subTotal' => NULL,'total' => NULL,'created_at' => '2016-06-10 18:20:03','updated_at' => '2016-06-10 18:20:03'),
            array('id' => '2','cancelled' => '0','sale_number' => '0','subTotal' => NULL,'total' => NULL,'created_at' => '2016-06-10 18:20:03','updated_at' => '2016-06-10 18:20:03'),
            array('id' => '3','cancelled' => '0','sale_number' => '0','subTotal' => NULL,'total' => NULL,'created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10'),
            array('id' => '4','cancelled' => '0','sale_number' => '0','subTotal' => NULL,'total' => NULL,'created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10')
        );


        foreach ($sales as $table){
            Sale::create($table);
        }

        /*
        Sale::create(['id' => '1', 'client_id' => '1' , 'sale_number' => '1', 'total' => 25.8]);*/

        $this->command->info('sales table seeded!');
    }

}

class SaleLineSeeder extends Seeder {

    public function run()
    {
        DB::table('sale_lines')->delete();

        $sale_lines = array(
            array('id' => '2','sale_id' => '3','command_id' => '3','command_line_id' => '7','item_id' => '1','quantity' => '1','size' => 'Verre','taxes' => NULL,'cost' => '6.25','created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10'),
            array('id' => '3','sale_id' => '3','command_id' => '3','command_line_id' => '8','item_id' => '2','quantity' => '1','size' => 'Pinte','taxes' => NULL,'cost' => '7.15','created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10'),
            array('id' => '4','sale_id' => '3','command_id' => '4','command_line_id' => '11','item_id' => '3','quantity' => '1','size' => 'Pichet','taxes' => NULL,'cost' => '14.95','created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10'),
            array('id' => '5','sale_id' => '4','command_id' => '4','command_line_id' => '9','item_id' => '1','quantity' => '1','size' => 'Verre','taxes' => NULL,'cost' => '6.25','created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10'),
            array('id' => '6','sale_id' => '4','command_id' => '4','command_line_id' => '10','item_id' => '2','quantity' => '1','size' => 'Pinte','taxes' => NULL,'cost' => '7.15','created_at' => '2016-06-10 18:34:10','updated_at' => '2016-06-10 18:34:10')
        );

        foreach ($sale_lines as $table){
            SaleLine::create($table);
        }

        /* SaleLine::create(['id' => '1', 'sale_id' => '1', 'item_id' => '1' , 'cost' => 3.78, 'quantity' => 5]);
         SaleLine::create(['id' => '2', 'sale_id' => '1', 'item_id' => '2' , 'cost' => 3.45, 'quantity' => 2]);*/

        $this->command->info('sale lines table seeded!');
    }

}

class ExtraSeeder extends Seeder {

    public function run()
    {
        DB::table('extras')->delete();

        $extras = array(
            array('id' => '1','name' => 'Lime','description' => '','effect' => '','value' => '0.00','status' => '0','avail_for_command' => 0,'slug' => 'Lime1047','created_at' => '2016-06-16 08:24:56','updated_at' => '2016-06-16 08:24:56'),
            array('id' => '2','name' => 'Bacon','description' => '','effect' => '+','value' => '2.00','status' => '0','avail_for_command' => 1,'slug' => 'Bacon8974','created_at' => '2016-06-16 08:25:27','updated_at' => '2016-06-16 08:25:27'),
            array('id' => '3','name' => 'Gratuit','description' => '','effect' => '/','value' => '100.00','status' => '0','avail_for_command' => 0,'slug' => 'Gratuit5238','created_at' => '2016-06-16 08:25:49','updated_at' => '2016-06-16 08:25:49'),
            array('id' => '4','name' => 'Double price','description' => '','effect' => '*','value' => '100.00','status' => '0','avail_for_command' => 0,'slug' => 'Double price8669','created_at' => '2016-06-16 08:27:05','updated_at' => '2016-06-16 08:27:05'),
            array('id' => '5','name' => 'Deduire taxes','description' => '','effect' => '/','value' => '12.99','status' => '0','avail_for_command' => 0,'slug' => 'Deduire taxes1540','created_at' => '2016-06-16 08:28:05','updated_at' => '2016-06-16 08:28:05')
        );

        foreach ($extras as $table){
            Extra::create($table);
        }

        $this->command->info('extras table seeded!');
    }

}

class ExtraItemTypeSeeder extends Seeder
{

    public function run()
    {
        DB::table('extra_item_types')->delete();

        $extra_item_types = array(
            array('id' => '1', 'extra_id' => '1', 'item_type_id' => '1', 'created_at' => '2016-06-16 08:24:56', 'updated_at' => '2016-06-16 08:24:56'),
            array('id' => '2', 'extra_id' => '1', 'item_type_id' => '2', 'created_at' => '2016-06-16 08:24:56', 'updated_at' => '2016-06-16 08:24:56'),
            array('id' => '3', 'extra_id' => '2', 'item_type_id' => '3', 'created_at' => '2016-06-16 08:25:27', 'updated_at' => '2016-06-16 08:25:27'),
            array('id' => '4', 'extra_id' => '2', 'item_type_id' => '4', 'created_at' => '2016-06-16 08:25:27', 'updated_at' => '2016-06-16 08:25:27'),
            array('id' => '5', 'extra_id' => '2', 'item_type_id' => '5', 'created_at' => '2016-06-16 08:25:27', 'updated_at' => '2016-06-16 08:25:27'),
            array('id' => '6', 'extra_id' => '3', 'item_type_id' => '1', 'created_at' => '2016-06-16 08:25:49', 'updated_at' => '2016-06-16 08:25:49'),
            array('id' => '7', 'extra_id' => '3', 'item_type_id' => '2', 'created_at' => '2016-06-16 08:25:49', 'updated_at' => '2016-06-16 08:25:49'),
            array('id' => '8', 'extra_id' => '3', 'item_type_id' => '3', 'created_at' => '2016-06-16 08:25:49', 'updated_at' => '2016-06-16 08:25:49'),
            array('id' => '9', 'extra_id' => '3', 'item_type_id' => '4', 'created_at' => '2016-06-16 08:25:49', 'updated_at' => '2016-06-16 08:25:49'),
            array('id' => '10', 'extra_id' => '3', 'item_type_id' => '5', 'created_at' => '2016-06-16 08:25:49', 'updated_at' => '2016-06-16 08:25:49'),
            array('id' => '11', 'extra_id' => '4', 'item_type_id' => '1', 'created_at' => '2016-06-16 08:27:05', 'updated_at' => '2016-06-16 08:27:05'),
            array('id' => '12', 'extra_id' => '4', 'item_type_id' => '2', 'created_at' => '2016-06-16 08:27:05', 'updated_at' => '2016-06-16 08:27:05'),
            array('id' => '13', 'extra_id' => '4', 'item_type_id' => '3', 'created_at' => '2016-06-16 08:27:05', 'updated_at' => '2016-06-16 08:27:05'),
            array('id' => '14', 'extra_id' => '4', 'item_type_id' => '4', 'created_at' => '2016-06-16 08:27:05', 'updated_at' => '2016-06-16 08:27:05'),
            array('id' => '15', 'extra_id' => '4', 'item_type_id' => '5', 'created_at' => '2016-06-16 08:27:05', 'updated_at' => '2016-06-16 08:27:05'),
            array('id' => '16', 'extra_id' => '5', 'item_type_id' => '1', 'created_at' => '2016-06-16 08:28:05', 'updated_at' => '2016-06-16 08:28:05'),
            array('id' => '17', 'extra_id' => '5', 'item_type_id' => '2', 'created_at' => '2016-06-16 08:28:05', 'updated_at' => '2016-06-16 08:28:05'),
            array('id' => '18', 'extra_id' => '5', 'item_type_id' => '3', 'created_at' => '2016-06-16 08:28:05', 'updated_at' => '2016-06-16 08:28:05'),
            array('id' => '19', 'extra_id' => '5', 'item_type_id' => '4', 'created_at' => '2016-06-16 08:28:05', 'updated_at' => '2016-06-16 08:28:05'),
            array('id' => '20', 'extra_id' => '5', 'item_type_id' => '5', 'created_at' => '2016-06-16 08:28:05', 'updated_at' => '2016-06-16 08:28:05')
        );

        foreach ($extra_item_types as $table) {
            ExtraItemType::create($table);
        }

        $this->command->info('extras table seeded!');
    }
}


class FilterSeeder extends Seeder {

    public function run()
    {
        DB::table('filters')->delete();

        $filters = array(
            array('id' => '1','name' => 'Dejeuner','description' => 'Menu dejeuner','importance' => '10','type' => '1.00','status' => '1','slug' => 'Dejeuner2250','created_at' => '2016-06-22 15:50:36','updated_at' => '2016-06-22 15:50:36'),
            array('id' => '2','name' => 'Souper','description' => '','importance' => '2','type' => '1.00','status' => '1','slug' => 'Souper2892','created_at' => '2016-06-22 15:50:53','updated_at' => '2016-06-22 15:50:53')
        );

        foreach ($filters as $table){
            Filter::create($table);
        }

        $this->command->info('extras table seeded!');
    }

}

class FilterItemTypeSeeder extends Seeder {

    public function run()
    {
        DB::table('filter_item_types')->delete();

        $filter_item_types = array(
            array('id' => '1','filter_id' => '1','item_type_id' => '4','created_at' => '2016-06-22 15:50:36','updated_at' => '2016-06-22 15:50:36'),
            array('id' => '2','filter_id' => '2','item_type_id' => '3','created_at' => '2016-06-22 15:50:53','updated_at' => '2016-06-22 15:50:53'),
            array('id' => '3','filter_id' => '2','item_type_id' => '5','created_at' => '2016-06-22 15:50:53','updated_at' => '2016-06-22 15:50:53')
        );

        foreach ($filter_item_types as $table){
            FilterItemType::create($table);
        }

        $this->command->info('extras table seeded!');
    }

}

class FilterItemSeeder extends Seeder {

    public function run()
    {
        DB::table('filter_items')->delete();

        $filter_items = array(
            array('id' => '1','filter_id' => '1','item_id' => '5','created_at' => '2016-06-22 15:50:36','updated_at' => '2016-06-22 15:50:36'),
            array('id' => '2','filter_id' => '2','item_id' => '1','created_at' => '2016-06-22 15:50:53','updated_at' => '2016-06-22 15:50:53')
        );


        foreach ($filter_items as $table){
            FilterItem::create($table);
        }

        $this->command->info('extras table seeded!');
    }

}
