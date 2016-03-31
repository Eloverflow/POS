<?php

use App\Models\Addons\Rfid\TableRfidBeer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemFieldList;
use App\Models\ERP\ItemType;
use App\Models\ERP\OrderLine;
use App\Models\ERP\Supplier;
use App\Models\ERP\Order;
use App\Models\ERP\Inventory;
use App\Models\Addons\Rfid\TableRfid;
use App\Models\Addons\Rfid\TableRfidRequest;
use App\Models\POS\Client;
use App\Models\POS\Sale;
use App\Models\POS\SaleLine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Beer;
use App\Models\POS\Day_Disponibilities;
use App\Models\POS\Disponibility;
use App\Models\Auth\User;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;
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
        Model::unguard();

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

        $this->call(EmployeeTitleSeeder::class);
        $this->call(EmployeeSeeder::class);

        $this->call(DisponibilitiesTableSeeder::class);
        $this->call(Day_DisponibilitiesTableSeeder::class);

        $this->call(SchedulesTableSeeder::class);
        $this->call(Day_SchedulesTableSeeder::class);

        $this->call(ClientSeeder::class);
        //$this->call(SaleSeeder::class);
        //$this->call(SaleLineSeeder::class);

        $this->call(PunchesTableSeeder::class);

        Model::reguard();
    }
}

class PunchesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('punches')->delete();

        Punch::create(['inout' => 'Dispo 1', 'employee_id' => 1, 'created_at' => '2016-02-24 15:00:00']);

        $this->command->info('Disponibilities table seeded!');
    }

}

class DisponibilitiesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('disponibilities')->delete();

        Disponibility::create(['name' => 'Dispo 1', 'employee_id' => 1]);

        $this->command->info('Disponibilities table seeded!');
    }

}

class Day_DisponibilitiesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('day_disponibilities')->delete();

        Day_Disponibilities::create(['disponibility_id' => 1,
            'day_number' => 0,
            'startTime' => date('15:00:00'),
            'endTime' => date('17:00:00')
        ]);

        Day_Disponibilities::create(['disponibility_id' => 1,
            'day_number' => 0,
            'startTime' => date('18:00:00'),
            'endTime' => date('19:55:00')
        ]);

        Day_Disponibilities::create(['disponibility_id' => 1,
            'day_number' => 3,
            'startTime' => date('20:00:00'),
            'endTime' => date('03:00:00')
        ]);
        $this->command->info('Day Disponibilities table seeded!');
    }

}


class SchedulesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('schedules')->delete();
        Schedule::create(['name' => 'Schedules 1', 'startDate' => '2016-02-07', 'endDate' => '2016-02-13']);

        $this->command->info('Schedules table seeded!');
    }

}

class Day_SchedulesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('day_schedules')->delete();

        Day_Schedules::create(['schedule_id' => 1,
            'day_number' => 0,
            'employee_id' => 1,
            'startTime' => date('15:00:00'),
            'endTime' => date('17:00:00')
        ]);

        Day_Schedules::create(['schedule_id' => 1,
            'day_number' => 0,
            'employee_id' => 1,
            'startTime' => date('18:00:00'),
            'endTime' => date('19:55:00')
        ]);

        Day_Schedules::create(['schedule_id' => 1,
            'day_number' => 3,
            'employee_id' => 1,
            'startTime' => date('20:00:00'),
            'endTime' => date('03:00:00')
        ]);
        $this->command->info('Day Schedules table seeded!');
    }

}



class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['name' => 'Labatt', 'email' => 'labatt@email.com', 'password' => 'pass12345']);

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

        ItemType::create(['type' => 'Beer', 'field_names' => 'brand,style,percent ', 'size_names' => 'Verre,Pinte,Pichet,Baril', 'slug' => 'beer']);
        ItemType::create(['type' => 'Drink', 'field_names' => 'flavour,color,author,percent', 'size_names' => 'Petit,Moyen,Gros', 'slug' => 'drink']);

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
            'custom_fields_array' => serialize(array('Alexander Keith','Red','5')),
            'size_prices_array' => serialize(array('6.25','8.12','16.75','175.99' ))]);

        Item::create([
            'item_type_id' => '1',
            'name' => 'Blue', 'description' => 'Tous mes sens sont émus d\'une volupté douce et pure.',
            'slug' => 'blue',
            'img_id' => 'Labatt Blue.jpg',
            'custom_fields_array' => serialize(array('Labatt','Dry','5.6')),
            'size_prices_array' => serialize(array('5.25','7.15','14.95','135.98' ))]);


        Item::create(['item_type_id' => '1',
            'name' => 'Coorslight',
            'description' => 'Voyez ce jeu exquis wallon, de graphie en kit mais bref.',
            'slug' => 'coorslight',
            'img_id' => 'Labatt Blue.jpg',
            'custom_fields_array' => serialize(array('Coors','Light','4.5')),
            'size_prices_array' => serialize(array('5.25','7.15','14.95','135.98' ))]);


        Item::create([
            'item_type_id' => '2',
            'name' => 'MyDrinkName',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ',
            'slug' => 'mydrinkname',
            'img_id' => 'drink.jpg',
            'custom_fields_array' => serialize(array('Sour','green','Jino', '20')),
            'size_prices_array' => serialize(array('2.25','5.00','7.95' ))]);

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
            'userId' => 1,
            'bonusSalary' => 1,
            'birthDate' => date('2016-01-01'),
            'hireDate' => date('2016-01-01')
        ]);
        $this->command->info('People table seeded!');
    }

}


class EmployeeTitleSeeder extends Seeder {
    public function run()
    {
        DB::table('employee_titles')->delete();

        EmployeeTitle::create([
            'name' => 'Barmaid',
            'baseSalary' => 12,
        ]);
        EmployeeTitle::create([
            'name' => 'Livreur',
            'baseSalary' => 12,
        ]);
        EmployeeTitle::create([
            'name' => 'Plongeur',
            'baseSalary' => 12,
        ]);
        EmployeeTitle::create([
            'name' => 'Cuisinier',
            'baseSalary' => 12,
        ]);
    }
}


class ClientSeeder extends Seeder {

    public function run()
    {
        DB::table('clients')->delete();

        Client::create(['id' => '1', 'credit' => 10, 'rfid_card_code' => '2784390787',  'slug' => '2784390787']);

        $this->command->info('clients table seeded!');
    }

}

/*

class SaleSeeder extends Seeder {

    public function run()
    {
        DB::table('sales')->delete();

        Sale::create(['id' => '1', 'client_id' => '1' , 'sale_number' => '1', 'total' => 25.8]);

        $this->command->info('sales table seeded!');
    }

}


class SaleLineSeeder extends Seeder {

    public function run()
    {
        DB::table('sale_lines')->delete();

        SaleLine::create(['id' => '1', 'sale_id' => '1', 'item_id' => '1' , 'cost' => 3.78, 'quantity' => 5]);
        SaleLine::create(['id' => '2', 'sale_id' => '1', 'item_id' => '2' , 'cost' => 3.45, 'quantity' => 2]);

        $this->command->info('sale lines table seeded!');
    }

}*/
