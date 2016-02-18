<?php

use App\Models\Addons\Rfid\TableRfidBeer;
use App\Models\ERP\Item;
use App\Models\ERP\ItemFieldList;
use App\Models\ERP\ItemType;
use App\Models\ERP\Supplier;
use App\Models\ERP\Order;
use App\Models\ERP\Inventory;
use App\Models\Addons\Rfid\TableRfid;
use App\Models\Addons\Rfid\TableRfidRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Beer;
use App\Models\POS\Day_Disponibilities;
use App\Models\POS\Disponibility;
use App\Models\Auth\User;
use App\Models\POS\Employee;
use App\Models\POS\EmployeeTitle;

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
        $this->call(OrdersTableSeeder::class);
        $this->call(ItemTypesTableSeeder::class);
        $this->call(ItemFieldListsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
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

        Model::reguard();
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
            'day' => date('2016-01-01'),
            'day_number' => 0,
            'startTime' => date('15:00:00'),
            'endTime' => date('17:00:00')
        ]);

        Day_Disponibilities::create(['disponibility_id' => 1,
            'day' => date('2016-01-01'),
            'day_number' => 0,
            'startTime' => date('18:00:00'),
            'endTime' => date('16:55:00')
        ]);

        Day_Disponibilities::create(['disponibility_id' => 1,
            'day' => date('2016-01-01'),
            'day_number' => 3,
            'startTime' => date('14:00:00'),
            'endTime' => date('16:00:00')
        ]);
        $this->command->info('Day Disponibilities table seeded!');
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


class ItemTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_types')->delete();

        ItemType::create(['type' => 'Beer', 'fields_names' => 'brand,style,percent ', 'slug' => 'beer']);
        ItemType::create(['type' => 'Drink', 'fields_names' => 'flavour,color,author,percent', 'slug' => 'drink']);

        $this->command->info('ItemTypes table seeded!');
    }

}


class ItemFieldListsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('item_field_lists')->delete();

        /*One for each item | this is an extention to have custum field for every type of item*/
        /*Every fiel could lead to a list of sugguestion by doing a select with the ItemType fields_names*/
        ItemFieldList::create(['field1' => 'Alexander Keith', 'field2' => 'Red', 'field3' => '5']);
        ItemFieldList::create(['field1' => 'Labatt', 'field2' => 'Dry', 'field3' => '5.6']);
        ItemFieldList::create(['field1' => 'Coors', 'field2' => 'Light', 'field3' => '4.5']);
        ItemFieldList::create(['field1' => 'Sour', 'field2' => 'green', 'field3' => 'Jino', 'field4' => '20']);

        $this->command->info('ItemFieldLists table seeded!');
    }

}


class ItemsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('items')->delete();

        /* The item type will define their item_field_name  */
        Item::create([
            'item_type_id' => '1',
            'item_field_list_id' => '1',
            'name' => 'Keith',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
            'slug' => 'keith']);

        Item::create([
            'item_type_id' => '1',
            'item_field_list_id' => '2',
            'name' => 'Blue', 'description' => 'Tous mes sens sont émus d\'une volupté douce et pure, comme l\'haleine du matin dans cette saison délicieuse. Seul, au milieu d\'une contrée qui semble fait exprès pour un coeur tel que mien.',
            'slug' => 'blue']);

        Item::create(['item_type_id' => '1',
            'item_field_list_id' => '3',
            'name' => 'Coorslight',
            'description' => 'Voyez ce jeu exquis wallon, de graphie en kit mais bref. Portez ce vieux whisky au juge blond qui fume sur son île intérieure, à côté de l\'alcôve ovoïde, où les bûches se consument dans l\'âtre.',
            'slug' => 'coorslight']);

        Item::create([
            'item_type_id' => '2',
            'item_field_list_id' => '4',
            'name' => 'MyDrinkName',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ',
            'slug' => 'mydrinkname']);

        $this->command->info('Items table seeded!');
    }

}

class InventoriesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('inventories')->delete();

        Inventory::create(['order_id' => '1', 'item_id' => '1', 'quantity' => '100', 'slug' => 'keith']);
        Inventory::create(['order_id' => '1', 'item_id' => '2', 'quantity' => '50',  'slug' => 'blue']);

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

class RfidTableBeerSeeder extends Seeder {

    public function run()
    {
        DB::table('rfid_table_beers')->delete();

        TableRfidBeer::create(['id' => '1', 'table_flash_card_hw_code' => '1', 'img_url' => 'ad1213213']);

        $this->command->info('rfid_table_beers table seeded!');
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
            'employeeTitle' => 1,
            'userId' => 1,
            'salary' => 12.2,
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
            'employeeTitle' => 1,
            'userId' => 1,
            'salary' => 12.2,
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
            'name' => 'Barmaid'
        ]);
        EmployeeTitle::create([
            'name' => 'Livreur'
        ]);
        EmployeeTitle::create([
            'name' => 'Plongeur'
        ]);
        EmployeeTitle::create([
            'name' => 'Cuisinier'
        ]);
    }
}